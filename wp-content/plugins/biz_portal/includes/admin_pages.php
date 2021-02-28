<?php
/**
 * Process admin pages
 * 
 * @package BizPortal_WP_Module
 * @subpackage includes
 */

/**
 * Create admin menu
 */
function biz_portal_create_admin_menu()
{
    //create new top-level menu
    add_menu_page('Business Portal Manager', 'Portal Manager', 'administrator', 'business-portal-manager', 'biz_portal_settings_page', 'dashicons-schedule',3);
//    add_menu_page( Business Portal Manager,Portal Manager, administrator, business-portal-manager, biz_portal_settings_page, dashicons-schedule, $position );
}

/**
 * Create admin sub menu
 */
function biz_portal_admin_submenu_page()
{
    add_submenu_page(
            'business-portal-manager', 'Business Portal Manager', 'Portal Dashboard', 'manage_options', 'business-portal-manager', 'biz_portal_settings_page');
    add_submenu_page(
            'business-portal-manager', 'List Companies', 'List Companies', 'manage_options', 'admin-list-companies', 'biz_portal_admin_submenu_list_companies');
    add_submenu_page(
            'business-portal-manager', 'Options', 'Options', 'manage_options', 'business-portal-options', 'biz_portal_admin_submenu_options');
    add_submenu_page(
            'business-portal-manager', 'Industries', 'Industries', 'manage_options', 'business-portal-industry', 'biz_portal_admin_submenu_industry');
    add_submenu_page(
            'business-portal-manager', 'Services', 'Services', 'manage_options', 'business-portal-service', 'biz_portal_admin_submenu_service');
    add_submenu_page(
            'business-portal-manager', 'Biz Types', 'Biz Types', 'manage_options', 'business-portal-type', 'biz_portal_admin_submenu_type');
    add_submenu_page(
            'business-portal-manager', 'Business Resources', 'Business Resources', 'manage_options', 'business-portal-resource', 'biz_portal_admin_submenu_resource');
    add_submenu_page(
            'business-portal-manager', 'Email Templates', 'Email Templates', 'manage_options', 'portal-email-template', 'biz_portal_admin_submenu_mailtemp');
//    add_submenu_page(
//            'business-portal-manager', 'Dashboard Stats', 'Dashboard Stats', 'manage_options', 'portal-dashboard-stats', 'biz_portal_admin_submenu_dashboard_stats');
    add_submenu_page(
            'business-portal-manager', 'Advertisements', 'Advertisements', 'manage_options', 'biz-portal-advertisement', 'biz_portal_admin_submenu_advertisement');
    add_submenu_page(
            'business-portal-manager', 'Banners & Sliders', 'Banners & Sliders', 'manage_options', 'biz-portal-sliders', 'biz_portal_admin_submenu_sliders');
    add_submenu_page(
            'business-portal-manager', 'Image Manager', 'Image Manager', 'manage_options', 'biz-portal-image', 'biz_portal_admin_image_manager');
     add_submenu_page(
            'business-portal-manager', 'Manage Pages', 'Manage Pages', 'manage_options', 'biz-portal-pages', 'biz_portal_admin_page_manager');
     add_submenu_page(
            'business-portal-manager', 'Manage Modules', 'Manage Modules', 'manage_options', 'biz-portal-modules', 'biz_portal_admin_submenu_modules');
}

function biz_portal_admin_submenu_options()
{
    include __DIR__ . '/pages/biz_portal_options.php';
}

add_action('admin_init', 'biz_portal_options_register_mysettings');

function biz_portal_options_register_mysettings()
{
    //register our settings
    register_setting('bizportal-settings-group', 'member_login_page');
    register_setting('bizportal-settings-group', 'signup_page');
    register_setting('bizportal-settings-group', 'login_score_interval');
    register_setting('bizportal-settings-group', 'sme_default_country');
    register_setting('bizportal-settings-group', 'welcome_page'); // welcome page for first time login users
    /*register_setting('bizportal-settings-group', 'member_group_investment');
    register_setting('bizportal-settings-group', 'member_group_partnerhip');
    register_setting('bizportal-settings-group', 'member_group_service_provider');*/
    register_setting('bizportal-settings-group', 'enable_account_activation_email');
    
}

function biz_portal_admin_submenu_list_companies()
{
    global $wpdb;
    $local_page = filter_input(INPUT_GET, 'local_page', FILTER_SANITIZE_STRING);

    if ($local_page === 'view')
        include __DIR__ . '/pages/view_companies.php';
    else
        include __DIR__ . '/pages/list_companies.php';
}

function biz_portal_admin_submenu_roles()
{
    ?>
    
    <?php
}

function biz_portal_settings_page()
{
    include __DIR__ . '/pages/manage_portal.php';
}

function biz_portal_admin_submenu_industry()
{
    $page_action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

    if ($page_action === 'delete')
        include __DIR__ . '/pages/action_industry.php';
    else
        include __DIR__ . '/pages/biz_portal_industry.php';
}

function biz_portal_admin_submenu_service()
{
    $page_action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

    if ($page_action === 'delete')
        include __DIR__ . '/pages/action_service.php';
    else
        include __DIR__ . '/pages/biz_portal_service.php';
    
}

function biz_portal_admin_submenu_type()
{
    $page_action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

    if ($page_action === 'delete')
        include __DIR__ . '/pages/action_biztype.php';
    else
        include __DIR__ . '/pages/biz_portal_type.php';
}

function biz_portal_admin_submenu_resource()
{
 $page_action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
 
 if ($page_action === 'view')
    include __DIR__ . '/pages/action_node.php';
 else
    include __DIR__ . '/pages/biztype_resource.php';
}

function biz_portal_admin_submenu_mailtemp()
{
 $page_action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
 
 if ($page_action === 'edit')
    include __DIR__ . '/pages/action_template.php';
 else
    include __DIR__ . '/pages/email_template.php';
}

function biz_portal_admin_submenu_dashboard_stats()
{
    include __DIR__ . '/pages/dashboard_stats.php';
}

function biz_portal_admin_submenu_advertisement()
{
    $page_action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    if ($page_action === 'edit' || $page_action === 'delete' || $page_action === 'add')
        include __DIR__ . '/pages/action_adds.php';
    else
        include __DIR__ . '/pages/biz_portal_adds.php';
}

function biz_portal_admin_submenu_sliders()
{
    include __DIR__ . '/pages/directory_slider.php';
}

function biz_portal_admin_image_manager()
{
    include __DIR__ . '/pages/image_manager.php';
}

function biz_portal_admin_page_manager()
{
    include __DIR__ . '/pages/page_manager.php';
}

function biz_portal_admin_submenu_modules()
{
    include __DIR__ . '/pages/module_manager.php';
}