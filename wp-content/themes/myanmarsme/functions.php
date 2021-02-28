<?php

require_once __DIR__ . '/Theme_Vars.php';

define("MAIN_COMPANY_NAME","MyanmarSMELink");

//Theme_Vars::add_script('jquery.bxslider.min.js', get_template_directory_uri() . '/assets/plugins/bxslider/jquery.bxslider.min.js');
//Theme_Vars::add_script('app.js', get_template_directory_uri() . '/assets/scripts/app.js');
//Theme_Vars::add_script('form-fileupload_2.js', get_template_directory_uri() . '/assets/scripts/form-fileupload_2.js');
//Theme_Vars::add_script('index.js', get_template_directory_uri() . '/assets/scripts/index.js');

remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version

add_action( 'init', 'myanmarsme_add_excerpts_to_pages' );
function myanmarsme_add_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}


function myanmarsme_login_styles() {
    ?>
    <style type="text/css">      
        body {
            background: #fff;
        } 
        body.login div#login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/images/logo.jpg);
            padding-bottom: 0px;
            width: 235px;
            height: 22px;
            background-size: auto auto;
        }
        body.login #wp-submit {
            background: none repeat scroll 0 0 #ff8503 !important;
            border: 1px solid #ff8503;
            color: #fff;
            border-radius: 0 !important;
            border-width: 0;
            box-shadow: none !important;
            font-size: 14px;
            outline: medium none !important;
            padding: 2px 14px;
            text-shadow: none;        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'myanmarsme_login_styles' );


function myanmarsme_login_logo_url() {
    return get_site_url();
}
add_filter( 'login_headerurl', 'myanmarsme_login_logo_url' );

function myanmarsme_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'myanmarsme_login_logo_url_title' );


add_action( 'wp_login_failed', 'myanmarsme_login_failed' ); // hook failed login

function myanmarsme_login_failed( $user ) {
    // check what page the login attempt is coming from
    $referrer = $_SERVER['HTTP_REFERER'];

    // check that were not on the default login page
    if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
        // make sure we don't already have a failed login attempt
        if ( !strstr($referrer, '?login=failed' )) {
            // Redirect to the login page and append a querystring of login failed
            wp_redirect( $referrer . '?login=failed');
        } else {
            wp_redirect( $referrer );
        }

        exit;
    }
}


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
    // Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/plugins/bootstrap/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('twitter-bootstrap-hover-dropdown', get_template_directory_uri() . '/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js', array('jquery'));
    wp_enqueue_script('jquery.slimscroll', get_template_directory_uri() . '/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js', array('jquery'));
    wp_enqueue_script('jquery.blockui', get_template_directory_uri() . '/assets/plugins/jquery.blockui.min.js', array('jquery'));
    wp_enqueue_script('jquery.cookie', get_template_directory_uri() . '/assets/plugins/jquery.cookie.min.js', array('jquery'));
    wp_enqueue_script('jquery.uniform', get_template_directory_uri() . '/assets/plugins/uniform/jquery.uniform.min.js', array('jquery'));
    
    wp_enqueue_script('jquery.fancybox.pack', get_template_directory_uri() . '/assets/plugins/fancybox/source/jquery.fancybox.pack.js', array('jquery'));
    wp_enqueue_script('jquery.themepunch.plugins', get_template_directory_uri() . '/assets/plugins/revolution_slider/rs-plugin/js/jquery.themepunch.plugins.min.js', array('jquery'));
    wp_enqueue_script('jquery.themepunch.revolution', get_template_directory_uri() . '/assets/plugins/revolution_slider/rs-plugin/js/jquery.themepunch.revolution.min.js', array('jquery'));
    wp_enqueue_script('jquery.slimscroll', get_template_directory_uri() . '/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js', array('jquery'));
    
    
    wp_enqueue_script('form-fileupload_2.js', get_template_directory_uri() . '/assets/scripts/form-fileupload_2.js', array('jquery'));
    wp_enqueue_script('jquery.ui.widget', get_template_directory_uri() . '/assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js', array('jquery'));
    wp_enqueue_script('tmpl.min', get_template_directory_uri() . '/assets/plugins/jquery-file-upload/js/vendor/tmpl.min.js', array('jquery'));
    wp_enqueue_script('load-image', get_template_directory_uri() . '/assets/plugins/jquery-file-upload/js/vendor/load-image.min.js', array('jquery'));
    wp_enqueue_script('canvas-to-blob', get_template_directory_uri() . '/assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js', array('jquery'));
    wp_enqueue_script('jquery.fileupload-all', get_template_directory_uri() . '/assets/jquery.fileupload-all.js', array('jquery'));    
    
    
    wp_enqueue_script('bootbox', get_template_directory_uri() . '/assets/plugins/bootbox/bootbox.min.js', array('jquery', 'bootstrap'));
    wp_enqueue_script('jquery.bxslider.min.js', get_template_directory_uri() . '/assets/plugins/bxslider/jquery.bxslider.min.js', array('jquery'));
    
    wp_enqueue_script('back-to-top', get_template_directory_uri() . '/assets/plugins/back-to-top.js', array('jquery'));
            
    
    //if(defined('FORM_SME_WIZARD') && FORM_SME_WIZARD) {
	wp_enqueue_script('jquery.validate.min.js', get_template_directory_uri() . '/assets/plugins/jquery-validation/dist/jquery.validate.min.js', array('jquery'));
    wp_enqueue_script('additional-methods.min.js', get_template_directory_uri() . '/assets/plugins/jquery-validation/dist/additional-methods.min.js', array('jquery'));
    wp_enqueue_script('jquery.bootstrap.wizard.min.js', get_template_directory_uri() . '/assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js', array('jquery'));
    wp_enqueue_script('form-wizard.js', get_template_directory_uri() . '/assets/scripts/form-wizard.js', array('jquery'));
    wp_enqueue_script('select2.min.js', get_template_directory_uri() . '/assets/plugins/select2/select2.min.js', array('jquery'));
    
    wp_enqueue_script('scripts_index.js', get_template_directory_uri() . '/assets/scripts/index.js', array('jquery', 'bootstrap'));
    wp_enqueue_script('scripts_app.js', get_template_directory_uri() . '/assets/scripts/app.js', array('jquery', 'bootstrap'));
    
    
    // Styles
        
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/plugins/font-awesome/css/font-awesome.min.css');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/plugins/bootstrap/css/bootstrap.min.css');
    
    wp_enqueue_style('jquery.fancybox.css', get_template_directory_uri() . '/assets/plugins/fancybox/source/jquery.fancybox.css');
    wp_enqueue_style('css.rs-style.css', get_template_directory_uri() . '/assets/plugins/revolution_slider/css/rs-style.css', array(), true, 'screen');
    wp_enqueue_style('rs-plugin.css.settings.css', get_template_directory_uri() . '/assets/plugins/revolution_slider/rs-plugin/css/settings.css', array(), true, 'screen');
    wp_enqueue_style('jquery.bxslider.css', get_template_directory_uri() . '/assets/plugins/bxslider/jquery.bxslider.css');
    
    wp_enqueue_style('jquery_fileupload-ui', get_template_directory_uri() . '/assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css', array('bootstrap'));   
    
    wp_enqueue_style('style-metronic', get_template_directory_uri() . '/assets/css/style-metronic.css', array('bootstrap'));
    wp_enqueue_style('style_css', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('themes_orange', get_template_directory_uri() . '/assets/css/themes/orange.css', array('bootstrap'));
    wp_enqueue_style('style-responsive_css', get_template_directory_uri() . '/assets/css/style-responsive.css', array('bootstrap'));
    
    wp_enqueue_style('custom_css', get_template_directory_uri() . '/assets/css/custom.css', array('jquery_fileupload-ui', 'style_css', 'style-responsive_css'));
    
    if (current_user_can('edit_post')) {
        wp_enqueue_script('admin_update.js', get_template_directory_uri() . '/assets/scripts/admin_update.js', array('jquery'));
    }

    if (is_front_page())
    {
        //wp_enqueue_script('index-script', get_template_directory_uri() . '/assets/scripts/index.js', array('jquery'), '20120206', true);
    }
}

add_action('wp_enqueue_scripts', 'sbps_msme_adding_scripts');

add_theme_support('post-thumbnails');
add_image_size( 'video-thumbnail', 250, 140, true );

add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);

function add_login_logout_link($items, $args)
{
    if ($args->theme_location != 'primary' && $args->menu != 'Menu 1')
        return $items;

    if (is_user_logged_in())
    {
        $loginoutlink = "<a href='" . wp_logout_url(site_url()) . "'><i class='fa fa-lock '></i> Logout</a>";
    }
    else
    {   
        $loginoutlink = "<a href='" . site_url("signin/") . "' class=''><i class='fa fa-lock '></i> Login/Join</a>";
    }
    $items_new = '<li class="nav-login-form">' 
            . $loginoutlink . '</li>';
    if (is_user_logged_in())
    {
        $my_account_active = '';
        if (defined('PARENT') && PARENT === 'MYACCOUNT') {
            $my_account_active = 'active';
        }
        $message_count = biz_portal_pm_new();
    	$items_new .= '<li id="menu_my_account" class="' . $my_account_active . '"><a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-other="false">';
    	if ($message_count > 0) {
    	    $items_new .='<span id="menu_message_count"><i class="fa fa-envelope"></i> ' . $message_count . '</span>';
    	}
    	
    	$items_new .= 'MY ACCOUNT <span class="pull-right mobile_only"><small><i class="fa fa-plus"></i></small></span></a>
    		<ul class="dropdown-menu">
    		    <li><a href="' . site_url(get_option('member_login_page')) . '">Dashboard</a></li>
    			<li><a href="' . site_url(get_option('member_login_page') . '/profile') . '" >Profile</a></li>    			
    			<li><a href="' . site_url(get_option('member_login_page') . '/messages') . '">Messages</a></li>
    			<li><a href="' . site_url(get_option('member_login_page') . '/favourites') . '">Favourites</a></li>
    		</ul></li>'; 
    }
    $items_new .= $items;
    return $items_new;
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

function myanmarsme_get_about_slider()
{
    $data = get_option('about_module_content');
    if($data['mode'] !='all'){
    ?>
    
    <div style="padding: 0px;" class="about_mod_img_right">
       <img src="<?php echo $data['abt_image']; ?>" alt="Faq-aboutgraph" class="img-responsive">
    </div>
    
    <?php 
    }
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


function getPageContent($id=0){
	
	$content = array();
	$post = get_page($id);
	if($post){
		$the_content = apply_filters('the_content', $post->post_content);
		$content['content'] = str_replace(']]>',']]>',$the_content);
		$the_title = apply_filters('the_title', $post->post_title);
		$content['title'] = $the_title;
	}
	return $content;
}

/**
 * Create pagination
 * 
 * @param resource $get
 * @param string $url
 * @param int $per_page
 * @param int $total_records
 * @param string $ul_classes
 * @param string $li_active_class
 */
function sbpssme_create_pager($get, $url, $per_page, $total_records, $ul_classes = '', $li_active_class='', $page_var = 'p')
{
    if ($total_records == 0)  
        return;
    
    if (!empty($get[$page_var]))
        $page = filter_var($get[$page_var], FILTER_VALIDATE_INT);
    if (!$page) $page = 1;
    $total_pages = ceil($total_records/$per_page);
    $parsed_url = parse_url($url);
    $query = array();
    if ($parsed_url['query']) {
        parse_str($parsed_url['query'], $query);
    }
    echo '<ul class="' . $ul_classes . '">';
    $url_prev = '';
    $url_prev_disabled = 'disabled="disabled"';
    $url_next = '';
    $url_last = '';
    $url_first = '';
    $url_next_disabled = 'disabled="disabled"';
    if ($page > 1) {
        $query[$page_var] = ($page-1);
        $url_prev = $parsed_url['path'] . '?' . http_build_query($query);
        $query[$page_var] = 1;
        //$url_first = $parsed_url['path'] . '?' . http_build_query($query);
        $url_prev_disabled = '';
    }
    if ($page < $total_pages) {
        $query[$page_var] = ($page+1);
        $url_next = $parsed_url['path'] . '?' . http_build_query($query);
        $query[$page_var] = $total_pages;
        //$url_last = $url_next = $parsed_url['path'] . '?' . http_build_query($query);
        $url_next_disabled = '';
    }
    
        
    //if ($page > 1) {        
    //    echo '<li><a ' . $url_prev_disabled . ' href="' . $url_first . '" title="First"><i class="fa fa-fast-backward"></i></a></li>';
    //}
    echo '<li><a ' . $url_prev_disabled . ' href="' . $url_prev . '" title="Previouse"><i class="fa fa-arrow-circle-left"></i></a></li>';
    $pager_start = 0;
    $pager_end = $total_pages;
    if ($total_pages > 10) {
        if ($page > 5) {
            $pager_start = (int)($page - 5);
        }
        else {
            $pager_start = 0;
        }
        if ($total_pages > ($pager_start + 10)) {
            $pager_end = (int)($pager_start + 10);     
        }
        else {
            $pager_end = $total_pages;
        }
    }    
    for($i=$pager_start; $i < $pager_end; $i++) {
        $query[$page_var] = ($i+1);
        $parsed_url['query'] = http_build_query($query);
        $url = $parsed_url['path'] . '?' . $parsed_url['query'];
        $active_class = '';
        if ($page == ($i+1))
            $active_class = $li_active_class;
        echo '<li class="' . $active_class . '"><a title="Page ' . ($i+1) . '" href="' . $url . '">' . ($i+1) . '</a></li>';
    }
    echo '<li><a ' . $url_next_disabled . ' href="' . $url_next . '" title="Next"><i class="fa fa-arrow-circle-right"></i></a></li>';
    //if ($page < $total_pages)
    //    echo '<li><a ' . $url_next_disabled . ' href="' . $url_last . '" title="Last"><i class="fa fa-fast-forward"></i></a></li>';
    echo '</ul><br />';
    echo '<div style="text-align:right;">&nbsp;</div>';
}

function pagination($pages = '', $range = 4)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<ul class=\"pagination pagination-centered\">";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo; First</a></li>";
         if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a></li>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li class=\"active\"><a href='#'>".$i."</a></li>" : "<li><a href='".get_pagenum_link($i)."' >".$i."</a></li>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<li><a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a></li>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>Last &raquo;</a></li>";
         echo "</ul>\n";
     }
}

add_filter('query_vars', 'parameter_queryvars');

function parameter_queryvars( $qvars )
{
	$qvars[] = 'page';
	return $qvars;	
}

function get_newsroom_menu($category){
	$newsroom_submenu = "";
	$node_categories = scoop_it_get_topics();
	$categories =array();
	foreach ($node_categories as $cat) :
		$categories[$cat->id]=$cat->cat_name;
	endforeach;
	$newsroom_submenu = "<ul class=\"dropdown-menu\">";
	//$newsroom_submenu .= "<li><a href=\"". site_url() ."/newsroom/\">All</a></li>";
	foreach ($categories as $key => $cat) :
          $active = ((isset($category)) && ($category == $key)) ? " class=\"active\" ":"";
          $newsroom_submenu .= "<li {$active}><a href=\"". site_url() ."/newsroom/?c=". $key ."\"> ". $cat ." </a></li>";
          $x++;
    endforeach;
    $newsroom_submenu .= "</ul>";
	return $newsroom_submenu;
}

