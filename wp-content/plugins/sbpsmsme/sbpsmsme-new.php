<?php
/**
 * Plugin Name: Custom Settings
 * Plugin URI: http://www.emirateswifi.com
 * Description: Custom setting for the website.
 * Version: 1.0
 * Author: Swiss Bureau Project Supply
 * Author URI: http://www.emirateswifi.com
 */

require_once __DIR__ . '/resource_wiget.php';
require_once __DIR__ . '/signup_wiget.php';

if (is_admin()) // admin actions
{
    add_action('admin_menu', 'plugin_admin_add_page');
    add_action('admin_init', 'register_custom_settings');
}

register_activation_hook(__FILE__, 'sbpsmsme_rewrite_flush');
register_activation_hook(__FILE__, 'tstm_rewrite_flush');
add_action('init', 'sbpssme_create_post_type');
add_action('init', 'tstm_create_post_type');
add_action('admin_head', 'sbpssme_custom_css');


/*function get_archives_resources_link( $link ) {

    return str_replace( get_site_url(), get_site_url() . '/resources', $link );
};*/
//add_filter( 'get_archives_link', 'get_archives_resources_link', 10, 2 );

function sbpssme_custom_css() {
   echo '<style type="text/css">
           div#itsec_sync_integration,
           div#itsec_security_updates,
           div#itsec_need_help,
           div#itsec_get_backup,
           div#a3_plugin_panel_extensions {
            	display:none;
            }
         </style>';
}

function sbpssme_create_post_type()
{
    register_post_type('success_story', array(
        'labels' => array(
            'name' => __('Success Stories'),
            'singular_name' => __('Success Story')
        ),
        'public' => true,
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'query_var' => true,
        'show_ui' => true,
        'menu_icon' => 'dashicons-welcome-widgets-menus',
        'rewrite' => array('slug' => 'success_story'),
        'supports' => array('title', 'editor', 'revisions', 'author', 'excerpt', 'thumbnail')
    ));

    $labels_taxo = array(
        'name' => _x('Story Type', 'taxonomy general name'),
        'singular_name' => _x('Story Types', 'taxonomy singular name'),
        'search_items' => __('Search Story Types'),
        'all_items' => __('All Story Types'),
        'parent_item' => __('Parent Story Type'),
        'parent_item_colon' => __('Parent Story Type:'),
        'edit_item' => __('Edit Story Type'),
        'update_item' => __('Update Story Type'),
        'add_new_item' => __('Add New Story Type'),
        'new_item_name' => __('New Story Type Name'),
        'menu_name' => __('Story Type'),
    );

    $args_taxo = array(
        'hierarchical' => true,
        'labels' => $labels_taxo,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'success-story'),
    );    

    register_taxonomy('sbpssme_resources_taxo', array('success_story'), $args_taxo);
}


function tstm_create_post_type()
{
    register_post_type('Testimonial', array(
        'labels' => array(
            'name' => __('Testimonial'),
            'singular_name' => __('Testimonial')
        ),
        'public' => true,
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'query_var' => true,
        'show_ui' => true,
        'menu_icon' => 'dashicons-welcome-widgets-menus',
        'rewrite' => array('slug' => 'testimonial'),
        'supports' => array('title', 'editor', 'revisions', 'author', 'excerpt', 'thumbnail')
    ));    

    register_taxonomy('tstm_taxo','testimonial');
}

function sbpsmsme_rewrite_flush()
{
    sbpssme_create_post_type();
    flush_rewrite_rules();
}

function tstm_rewrite_flush()
{
    tstm_create_post_type();
    flush_rewrite_rules();
}

function sme_get_custom_field($field, $post_id)
{
    $ret_field = '';
    switch ($field)
    {
        case 'link_text':
            $ret_field = 'sbpsmesme_field_linktext';
            break;
        case 'link_url':
            $ret_field = 'sbpsmesme_field_url';
            break;
        default:
            return false;
    }

    return get_post_meta($post_id, $ret_field, true);
}

function tstm_get_custom_field($field, $post_id)
{
    $ret_field = '';
    switch ($field)
    {
        case 'link_text':
            $ret_field = 'tstm_field_linktext';
            break;
        case 'youtube_url':
            $ret_field = 'tstm_field_url_youtube';
            break;
        case 'youku_url':
            $ret_field = 'tstm_field_url_youku';
            break;
        default:
            return false;
    }

    return get_post_meta($post_id, $ret_field, true);
}


function sme_get_resource_categories($post_id)
{
    return get_the_terms($post_id, 'sbpssme_resources_taxo');
}

function sme_get_all_resource_categories()
{
    $args = array(
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => true,
        'exclude' => array(),
        'exclude_tree' => array(),
        'include' => array(),
        'number' => '',
        'fields' => 'all',
        'slug' => '',
        'parent' => '',
        'hierarchical' => true,
        'child_of' => 0,
        'get' => '',
        'name__like' => '',
        'pad_counts' => false,
        'offset' => '',
        'search' => '',
        'cache_domain' => 'core'
    );
    
    return get_terms('sbpssme_resources_taxo', $args);
}

function sme_get_all_resource_tags()
{
    $args = array(
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => true,
        'exclude' => array(),
        'exclude_tree' => array(),
        'include' => array(),
        'number' => '',
        'fields' => 'all',
        'slug' => '',
        'parent' => '',
        'hierarchical' => true,
        'child_of' => 0,
        'get' => '',
        'name__like' => '',
        'pad_counts' => false,
        'offset' => '',
        'search' => '',
        'cache_domain' => 'core'
    );
    
    return get_terms('sbpssme_resources_tags', $args);
}



function tstm_get_all_tags()
{
    $args = array(
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => true,
        'exclude' => array(),
        'exclude_tree' => array(),
        'include' => array(),
        'number' => '',
        'fields' => 'all',
        'slug' => '',
        'parent' => '',
        'hierarchical' => true,
        'child_of' => 0,
        'get' => '',
        'name__like' => '',
        'pad_counts' => false,
        'offset' => '',
        'search' => '',
        'cache_domain' => 'core'
    );
    
    return get_terms('tstm_tags', $args);
}

function sme_get_resource_tags($post_id)
{
    return get_the_terms($post_id, 'sbpssme_resources_tags');
}

function tstm_get_tags($post_id)
{
    return get_the_terms($post_id, 'tstm_tags');
}

function sbpsmsme_add_resource_meta_box()
{
    add_meta_box(
            'resources_extra', // $id
            'Resources Extra', // $title 
            'sbpsmsme_show_resource_meta_box', // $callback
            'success_story', // $page
            'normal', // $context
            'high' // $priority
    );
}

function tstm_add_meta_box()
{
    add_meta_box(
            'tstm_links', // $id
            'Testimonial Links', // $title 
            'tstm_show_meta_box', // $callback
            'testimonial', // $page
            'normal', // $context
            'high' // $priority
    );
}

add_action('add_meta_boxes', 'sbpsmsme_add_resource_meta_box');
add_action('add_meta_boxes', 'tstm_add_meta_box');

function sbpsmsme_show_resource_meta_box()
{
    global $post;
    $meta_linktext = get_post_meta($post->ID, 'sbpsmesme_field_url_youku', true);
    $meta_url = get_post_meta($post->ID, 'sbpsmesme_field_url_youtube', true);
    $meta_tube_duration = biz_portal_get_video_duration('youtube',$meta_url);
    $meta_ku_duration = biz_portal_get_video_duration('youku',$meta_linktext);
    echo '<input type="hidden" name="resources_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
     echo '<input type="hidden" name="sbpsmesme_duration_youku" value="' .$meta_ku_duration. '" />';
      echo '<input type="hidden" name="sbpsmesme_duration_youtube" value="' .$meta_tube_duration. '" />';
    echo '<table class="form-table">';
    echo '<tr>
                <th><label for="sbpsmesme_field_url_youku">Youku URL 
                <img src="http://www.havas-se.com/images/frontend/social/youku.png" width="16" height="16" /></label></th>
                <td>';
    echo '<input type="text" name="sbpsmesme_field_url_youku" id="sbpsmesme_field_url_youku" value="' . $meta_linktext . '" size="60" />
        <br /><span class="description">URL for YOUKU Video.</span>';
    echo '</td></tr>';
    echo '<tr>
                <th><label for="sbpsmesme_field_url_youtube">Youtube URL 
                <img src="http://www.goingclear.com/images/youtube_icon.png" width="16" height="16" /></label></th>
                <td>';
    echo '<input type="text" name="sbpsmesme_field_url_youtube" id="sbpsmesme_field_url_youtube" value="' . $meta_url . '" size="60" />
        <br /><span class="description">URL for YOUTUBE Video.</span>';
    echo '</td></tr>';
    echo '</table>'; // end table
}

function tstm_show_meta_box()
{
    global $post;
    $meta_youku_url = get_post_meta($post->ID, 'tstm_field_url_youku', true);
    $meta_youtube_url = get_post_meta($post->ID, 'tstm_field_url_youtube', true);
    echo '<input type="hidden" name="meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
    echo '<table class="form-table">';
    echo '<tr>
                <th><label for="tstm_field_url_youku">Youku URL 
                <img src="http://www.havas-se.com/images/frontend/social/youku.png" width="16" height="16" /></label></th>
                <td>';
    echo '<input type="text" name="tstm_field_url_youku" id="tstm_field_url_youku" value="' . $meta_youku_url . '" size="60" />
        <br /><span class="description">URL for YOUKU Video.</span>';
    echo '</td></tr>';
    echo '<tr>
                <th><label for="tstm_field_url_youtube">Youtube URL 
                <img src="http://www.goingclear.com/images/youtube_icon.png" width="16" height="16" /></label></th>
                <td>';
    echo '<input type="text" name="tstm_field_url_youtube" id="tstm_field_url_youtube" value="' . $meta_youtube_url . '" size="60" />
        <br /><span class="description">URL for YOUTUBE Video.</span>';
    echo '</td></tr>';
    echo '</table>'; // end table
}

function sbpsmsme_save_resource_meta($post_id)
{
    if (!wp_verify_nonce($_POST['resources_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

    if ('resources' == $_POST['post_type'])
    {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id))
    {
        return $post_id;
    }

    $old_meta_linktext = get_post_meta($post_id, 'sbpsmesme_field_url_youku', true);
    $old_meta_url = get_post_meta($post_id, 'sbpsmesme_field_url_youtube', true);

    $new_meta_linktext = $_POST['sbpsmesme_field_url_youku'];
    $new_meta_url = $_POST['sbpsmesme_field_url_youtube'];

    if ($new_meta_linktext && $new_meta_linktext != $old_meta_linktext)
    {
        $new_youku_duraion = biz_portal_get_video_duration('youku',$new_meta_linktext);
        update_post_meta($post_id, 'sbpsmesme_field_url_youku', $new_meta_linktext);
        update_post_meta($post_id, 'sbpsmesme_duration_youku', $new_youku_duraion);
    }
    else if ('' == $new_meta_linktext && $old_meta_linktext)
    {
        $old_youku_duraion = biz_portal_get_video_duration('youku',$old_meta_linktext);
        delete_post_meta($post_id, 'sbpsmesme_field_url_youku', $old_meta_linktext);
        delete_post_meta($post_id, 'sbpsmesme_duration_youku', $old_youku_duraion);
    }

    if ($new_meta_url && $new_meta_url != $old_meta_url)
    {
        $new_youtube_duraion = biz_portal_get_video_duration('youtube',$new_meta_url);
        update_post_meta($post_id, 'sbpsmesme_field_url_youtube', $new_meta_url);
        update_post_meta($post_id, 'sbpsmesme_duration_youtube', $new_youtube_duraion);
    }
    else if ('' == $new_meta_url && $old_meta_url)
    {
        $old_youtube_duraion = biz_portal_get_video_duration('youtube',$old_meta_url);
        delete_post_meta($post_id, 'sbpsmesme_field_url_youtube', $old_meta_url);
        delete_post_meta($post_id, 'sbpsmesme_duration_youtube', $old_youtube_duraion);
    }
}

add_action('save_post', 'sbpsmsme_save_resource_meta');

function tstm_save_meta($post_id)
{
    if (!wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

    if ('resources' == $_POST['post_type'])
    {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id))
    {
        return $post_id;
    }

    $old_meta_youku_url = get_post_meta($post_id, 'tstm_field_url_youku', true);
    $old_meta_youtube_url = get_post_meta($post_id, 'tstm_field_url_youtube', true);

    $new_meta_youku_url = $_POST['tstm_field_url_youku'];
    $new_meta_youtube_url = $_POST['tstm_field_url_youtube'];

    if ($new_meta_youku_url && $new_meta_youku_url != $old_meta_youku_url)
    {
        update_post_meta($post_id, 'tstm_field_url_youku', $new_meta_youku_url);
    }
    else if ('' == $new_meta_youku_url && $old_meta_youku_url)
    {
        delete_post_meta($post_id, 'tstm_field_url_youku', $old_meta_youku_url);
    }

    if ($new_meta_youtube_url && $new_meta_youtube_url != $old_meta_youtube_url)
    {
        update_post_meta($post_id, 'tstm_field_url_youtube', $new_meta_youtube_url);
    }
    else if ('' == $new_meta_youtube_url && $old_meta_youtube_url)
    {
        delete_post_meta($post_id, 'tstm_field_url_youtube', $old_meta_youtube_url);
    }
}

add_action('save_post', 'tstm_save_meta');





/**
 * 
 * @param int $count
 * @return WP_Query
 */
function sbpsmsme_latest_resources($count = 4)
{
    if (!is_numeric($count) || $count < 0)
        return;
    $query = new WP_Query('post_type=resources&posts_per_page=' . $count);
    return $query;
}

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'resource-xxxsmall', 90, 50, true ); //(cropped)
}

function plugin_admin_add_page()
{
    global $submenu;
    //add_options_page('Custom Settings', 'Custom Settings', 'manage_options', '', 'plugin_options_page');
    add_submenu_page('business-portal-manager', 'Custom Settings', 'Custom Settings', 5, 'plugin', 'plugin_options_page');
    unset( $submenu['business-portal-manager'][0] );
    //add_submenu_page("my-menu-slug", "My Submenu", "My Submenu", 0, "my-submenu-slug", "mySubmenuPageFunction");
   
}

function register_custom_settings() // whitelist options
{
    register_setting('custom_website_settings', 'contact_address');
    register_setting('custom_website_settings', 'contact_email_1');
    register_setting('custom_website_settings', 'contact_email_2');
    register_setting('custom_website_settings', 'contact_email_3');
    register_setting('custom_website_settings', 'contact_telephone_1');
    register_setting('custom_website_settings', 'contact_telephone_2');
    register_setting('custom_website_settings', 'contact_telephone_3');
    register_setting('custom_website_settings', 'contact_fax');
    register_setting('custom_website_settings', 'contact_mobile');
    register_setting('custom_website_settings', 'social_fb_link');
    register_setting('custom_website_settings', 'social_google_link');
    register_setting('custom_website_settings', 'social_twitter_link');
    register_setting('custom_website_settings', 'social_linkedin_link');
    register_setting('custom_website_settings', 'social_youtube_link');
    register_setting('custom_website_settings', 'social_pinterest_link');
    register_setting('custom_website_settings', 'social_rss_link');

    register_setting('custom_website_settings', 'scoop_fetch_count');    
    register_setting('custom_website_settings', 'scoop_topic_ids');
    
    register_setting('custom_website_settings', 'score_different_category');
    register_setting('custom_website_settings', 'score_posting_resource');
    register_setting('custom_website_settings', 'score_creating_post');
    register_setting('custom_website_settings', 'score_login');
    register_setting('custom_website_settings', 'score_posting_downloads');
    
    register_setting('custom_website_settings', 'ip_country_ids');
    
    register_setting('custom_website_settings', 'filter_country_list');
    
    
}

function plugin_options_page()
{
    $current=filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_STRING);
    if (!$current)
        $current = 'address';
    ?>
    <div class="wrap">
        <h2>Custom Settings</h2>
        Custom website settings and data        
        <form action="options.php" method="post">
        <?php settings_fields('custom_website_settings'); ?>
        <?php do_settings_sections('custom_website_settings'); ?>

            <h2 class="nav-tab-wrapper">
            <?php $class = ( "address" === $current ) ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=plugin&tab=address">Address</a>
            <?php $class = ( "scoop" === $current ) ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=plugin&tab=scoop">Scoop</a>            
            <?php $class = ( "score" === $current ) ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=plugin&tab=score">Score Setting</a>
            <?php $class_v = ( "ip_country" === $current ) ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=plugin&tab=ip_country">Exceptional Countries</a>
            <?php $class_v = ( "filter" === $current ) ? ' nav-tab-active' : ''; ?>
            <a class="nav-tab<?php echo $class; ?>" href="?page=plugin&tab=filter">Form Filter</a>
            
            <?php $class_v = ( "address" === $current ) ? '' : ' hidden'; ?>
            <div class='<?php echo $class_v ?>'>
            <h2>Address Settings</h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Address</th>
                    <td><textarea type="text" cols="40" rows="6" name="contact_address"><?php echo get_option('contact_address'); ?></textarea></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Email 1</th>
                    <td><input type="text" name="contact_email_1" value="<?php echo get_option('contact_email_1'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Email 2</th>
                    <td><input type="text" name="contact_email_2" value="<?php echo get_option('contact_email_2'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Email 3</th>
                    <td><input type="text" name="contact_email_3" value="<?php echo get_option('contact_email_3'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Telephone 1</th>
                    <td><input type="text" name="contact_telephone_1" value="<?php echo get_option('contact_telephone_1'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Telephone 2</th>
                    <td><input type="text" name="contact_telephone_2" value="<?php echo get_option('contact_telephone_2'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Telephone 3</th>
                    <td><input type="text" name="contact_telephone_3" value="<?php echo get_option('contact_telephone_3'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Fax</th>
                    <td><input type="text" name="contact_fax" value="<?php echo get_option('contact_fax'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Mobile</th>
                    <td><input type="text" name="contact_mobile" value="<?php echo get_option('contact_mobile'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Social link : Facebook</th>
                    <td><input type="text" name="social_fb_link" value="<?php echo get_option('social_fb_link'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Social link : Google+</th>
                    <td><input type="text" name="social_google_link" value="<?php echo get_option('social_google_link'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Social link : Twitter</th>
                    <td><input type="text" name="social_twitter_link" value="<?php echo get_option('social_twitter_link'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Social link : LinkedIn</th>
                    <td><input type="text" name="social_linkedin_link" value="<?php echo get_option('social_linkedin_link'); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Social link : Youtube</th>
                    <td><input type="text" name="social_youtube_link" value="<?php echo get_option('social_youtube_link'); ?>" /></td>
                </tr>
                
                <tr valign="top">
                    <th scope="row">Social link : Pinterest</th>
                    <td><input type="text" name="social_pinterest_link" value="<?php echo get_option('social_pinterest_link'); ?>" /></td>
                </tr> 

                <tr valign="top">
                    <th scope="row">Social link : RSS</th>
                    <td><input type="text" name="social_rss_link" value="<?php echo get_option('social_rss_link'); ?>" /></td>
                </tr>     

            </table>   
            </div>
            <?php $class_v = ( "scoop" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
                <h2>Scoop Settings</h2>
                <table class="form-table">
                <tr valign="top">
                    <th scope="row">Fetch count</th>
                    <td><input type="text" cols="40" rows="6" name="scoop_fetch_count" value="<?php echo get_option('scoop_fetch_count'); ?>" /><br />
                    <i>The amount of records per topic to keep in local database. Min = 3 and Max = 200, Default 30.</i></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Topic IDs</th>
                    <td><textarea type="text" cols="40" rows="6" name="scoop_topic_ids"><?php echo get_option('scoop_topic_ids'); ?></textarea>
                    <br /><i>Insert 1 topic id per line</i></td>                    
                </tr>
                </table>
            </div>   
            <?php $class_v = ( "score" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
            	<h2>Score Settings</h2>
            	<table class="form-table">
            	<tr valign="top">
            		<th scope="row">Differet Category registration</th>
            		<td><input type="text" cols="40" rows="6" name="score_different_category" value="<?php echo get_option('score_different_category'); ?>" /></td>
            	</tr>
            	<tr valign="top">
            		<th scope="row">Posting a Resource</th>
            		<td><input type="text" cols="40" rows="6" name="score_posting_resource" value="<?php echo get_option('score_posting_resource'); ?>" /></td>
            	</tr>
            	<tr valign="top">
            		<th scope="row">Creating a Post</th>
            		<td><input type="text" cols="40" rows="6" name="score_creating_post" value="<?php echo get_option('score_creating_post'); ?>" /></td>
            	</tr>
            	<tr valign="top">
            		<th scope="row">Login</th>
            		<td><input type="text" cols="40" rows="6" name="score_login" value="<?php echo get_option('score_login'); ?>" /></td>
            	</tr>
            	<tr valign="top">
            		<th scope="row">Posting Downloads</th>
            		<td><input type="text" cols="40" rows="6" name="score_posting_downloads" value="<?php echo get_option('score_posting_downloads'); ?>" /></td>
            	</tr>
            	</table>
            </div>
            <?php $class_v = ( "ip_country" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
                <h2>Manage IP-Countries List</h2>
                <table class="form-table">
                <tr valign="top">
                    <th scope="row">Country CODE's</th>
                    <td><textarea type="text" cols="40" rows="6" name="ip_country_ids"><?php echo get_option('ip_country_ids'); ?></textarea>
                        <br /><B>Insert 'One' Country CODE per line</B>
                         <br />*<i>Country CODE Must Be In ISO Country Code</i>
                    </td>                    
                </tr>
                </table>
            </div>
            <?php $class_v = ( "filter" === $current ) ? '' : ' hidden'; ?>
            <div class="<?php echo $class_v ?>">
                <h2>Filter Countries</h2>
                <table class="form-table">
                <tr valign="top">
                    <th scope="row">Details</th>
                    <td><textarea type="text" cols="40" rows="6" name="filter_country_list"><?php echo get_option('filter_country_list'); ?></textarea>
                        <br /><B>Insert 'One' Country Detail per line</B>
                         <br />*<i>Country CODE Must Be In ISO Country Code & Divide details with '|'</i>
                    </td>                    
                </tr>
                </table>
            </div> 
            </h2>
    <?php submit_button(); ?>
        </form>
    </div>

    <?php
}
