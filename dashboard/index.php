<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
session_start();
define('WP_USE_THEMES', true);
define('PRIVATE', true, true);

/** Loads the WordPress Environment and Template */
//require( dirname( __FILE__ ) . '/../wp-blog-header.php' );

//require_once( ABSPATH . WPINC . '/../template-loader.php' );
if ( !isset($wp_did_header) ) {

	$wp_did_header = true;

	require_once( dirname(__FILE__) . '/../wp-load.php' );

	//wp();

	//require_once( ABSPATH . WPINC . '/template-loader.php' );

}

//
// check if user is logged in, if not redirect to home url
//
if (!is_user_logged_in())
{
	wp_redirect(site_url('signin'));
	exit();
}


require_once (dirname(__FILE__) . '/pages.config.php');

$page_name = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

$current_company_id = biz_portal_get_current_company_id();
$current_company = biz_portal_get_company($current_company_id);

// if the company is activated, terms will be set to 2, so he must accept again to make it 1
// unless can not use dashboard
if ($current_company->terms_accepted != 1 && strtolower($page_name) != 'welcome') {
    $page_name = 'welcome';
}

if ($current_company->terms_accepted == 1 && $page_name === 'welcome') {
    $page_name = 'dashboard';
}

if ($current_company->terms_accepted == 1 )
{
    $BP_CompanyProfile = biz_portal_get_company_profile($current_company_id);
    
    if ($BP_CompanyProfile == null) {
        $link = site_url('dashboard/profile/details');
        $link = '<a href="' . $link . '">here</a>';
        BP_FlashMessage::Add("You do not have completed the profile yet, please click {$link} to update it now.", BP_FlashMessage::INFO);
    }
}

$page_file_name = $pages_array[strtolower($page_name)];

if ($page_file_name) {
	if (file_exists(dirname(__FILE__) . '/' . $page_file_name))
	{
		include_once(dirname(__FILE__) . '/' . $page_file_name);
		
	}
	else {
		wp_redirect(home_url('/'), 404);
	}	
}
else {
	wp_redirect(home_url('/'), 404);
}
