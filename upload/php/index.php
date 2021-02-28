<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

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
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
//require( dirname( __FILE__ ) . '/../wp-blog-header.php' );

//require_once( ABSPATH . WPINC . '/../template-loader.php' );
if ( !isset($wp_did_header) ) {

	$wp_did_header = true;

	require_once( dirname(__FILE__) . '/../../wp-load.php' );

	//wp();

	//require_once( ABSPATH . WPINC . '/template-loader.php' );

}

error_reporting(E_ALL | E_STRICT);
require(__DIR__ . '/BP_Fileupload.php');
$upload_handler = new BP_FileUpload($wpdb, get_current_user_id());
