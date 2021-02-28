<?php
/**
 * @package BizPortal_WP_Module
 */

/**
 * Plugin Name: Business Portal
 * Plugin URI: http://www.emirateswifi.net/
 * Description: Business portal for the MyanmarSME website
 * Version: 1.0
 * Author: Swiss Bureau Project Supply
 * Author URI: http://www.emirateswifi.net
 * License: Proprietory
 */

define('EMAIL_DISABLED', false, true);
if (!defined('MAIN_COMPANY_NAME'))
    define('MAIN_COMPANY_NAME', 'MyanmarSMELink', true);

// Typical includes

require_once(__DIR__ . "/includes/BP_BaseRepository.php");
require_once(__DIR__ . "/includes/BP_Repo_Companies.php");
require_once(__DIR__ . "/includes/BP_Repo_Nodes.php");
require_once(__DIR__ . "/includes/BP_Repo_Files.php");
require_once(__DIR__ . "/includes/BP_Repo_Favourites.php");
require_once(__DIR__ . "/includes/BP_Repo_Messages.php");
require_once(__DIR__ . "/includes/admin_pages.php");
require_once(__DIR__ . "/includes/install.php");
require_once(__DIR__ . "/includes/BP_Hydrator.php");
require_once(__DIR__ . "/includes/BP_Company_Filter.php");
require_once(__DIR__ . "/includes/BP_Directory_Filter.php");
require_once(__DIR__ . "/includes/BP_FlashMessage.php");
require_once(__DIR__ . "/includes/BP_VisitPageType.php");
// Entities
require_once(__DIR__ . "/entities/BP_Address.php");
require_once(__DIR__ . "/entities/BP_AdsClick.php");
require_once(__DIR__ . "/entities/BP_Advertisement.php");
require_once(__DIR__ . "/entities/BP_BizNeedDetail.php");
require_once(__DIR__ . "/entities/BP_BizNeedInvestment.php");
require_once(__DIR__ . "/entities/BP_BizNeedNGOSuppServ.php");
require_once(__DIR__ . "/entities/BP_BizNeedType.php");
require_once(__DIR__ . "/entities/BP_BizService.php");
require_once(__DIR__ . "/entities/BP_BizType.php");
require_once(__DIR__ . "/entities/BP_File.php");
require_once(__DIR__ . "/entities/BP_Company.php");
require_once(__DIR__ . "/entities/BP_CompanyProfile.php");
require_once(__DIR__ . "/entities/BP_Contact.php");
require_once(__DIR__ . "/entities/BP_Country.php");
require_once(__DIR__ . "/entities/BP_Favourite.php");
require_once(__DIR__ . "/entities/BP_Industry.php");
require_once(__DIR__ . "/entities/BP_MemberType.php");
require_once(__DIR__ . "/entities/BP_Node.php");
require_once(__DIR__ . "/entities/BP_PrivateMessage.php");
require_once(__DIR__ . "/entities/BP_Score.php");
require_once(__DIR__ . "/entities/BP_NodeCategory.php");
require_once(__DIR__ . "/entities/BP_CustomPage.php");
// view models
require_once(__DIR__ . "/view_models/ViewModel_Companies.php");
require_once(__DIR__ . "/view_models/ViewModel_Nodes.php");
require_once(__DIR__ . "/view_models/ViewModel_Messages.php");
// Others
require_once(__DIR__ . "/entities/wp_column_types.php");
require_once(__DIR__ . "/signup/Signup_Abstract.php");
require_once(__DIR__ . "/signup/International.php");
require_once(__DIR__ . "/signup/Local.php");
require_once(__DIR__ . "/signup/NGO.php");


define('ENABLE_VISIT_LOGS', true, true);


/** 
 * save if new industry posted by applicant.
 * @var bool BIZ_PORTAL_SAVE_NEW_INDUSTRY
 */
define("BIZ_PORTAL_SAVE_NEW_INDUSTRY", get_option("biz_portal_save_new_industry"), false);
/** 
 * Completely remove including any settings while uninstallation.
 * @var bool BIZ_PORTAL_WIPEALL_ON_UNINSTALL
 */
define('BIZ_PORTAL_WIPEALL_ON_UNINSTALL', TRUE);
/** 
 * Member type local (SME).
 * max 10 chars
 * @var string BIZ_PORTAL_MEMBER_TYPE_LOCAL
 */
define('BIZ_PORTAL_MEMBER_TYPE_LOCAL', BP_MemberType::TYPE_SME, TRUE);
/**
 * Member type international (Service Provider). 
 * max 10 chars
 * @var string BIZ_PORTAL_MEMBER_TYPE_INTL
 */
define('BIZ_PORTAL_MEMBER_TYPE_INTL', BP_MemberType::TYPE_INTL, TRUE);
/**
 * @var string BIZ_PORTAL_EMAIL_WELCOME
 */
define('BIZ_PORTAL_EMAIL_WELCOME', 'WELCOME', TRUE);
/**
 * @var string BIZ_PORTAL_EMAIL_REG_REJECTED
 */
define('BIZ_PORTAL_EMAIL_REG_REJECTED', 'REG_REJECTED', TRUE);
/**
 * @var string BIZ_PORTAL_EMAIL_RESRC_APPROVED
 */
define('BIZ_PORTAL_EMAIL_RESRC_APPROVED', 'RESRC_APPROVED', TRUE);
/**
 * @var string BIZ_PORTAL_EMAIL_PRIVATE_MESSAGE_NEW
 */
define('BIZ_PORTAL_EMAIL_PRIVATE_MESSAGE_NEW', 'PRIVATE_MESSAGE_NEW', TRUE);
/**
 * @var string BIZ_PORTAL_EMAIL_PRIVATE_MESSAGE_REP
 */
define('BIZ_PORTAL_EMAIL_PRIVATE_MESSAGE_REP', 'PRIVATE_MESSAGE_REP', TRUE);


/** @var string[] Table names  */
$biz_portal_table_names = array(
	'biz_need_services' => $wpdb->prefix . 'biz_need_services',
	'biz_need_partner_biz_type' => $wpdb->prefix . 'biz_need_partner_biz_type',
	'biz_need_partner_industries' => $wpdb->prefix . 'biz_need_partner_industries',
	'company_biz_types' => $wpdb->prefix . 'company_biz_types',
	'company_biz_types' => $wpdb->prefix . 'company_biz_types',
	'company_industry' => $wpdb->prefix . 'company_industry',
);

add_filter('login_redirect', 'biz_portal_login_redirect', 10, 3);
add_action('admin_menu', 'biz_portal_create_admin_menu');
add_action('init', 'biz_portal_init');
add_action('wp_login','biz_portal_capture_last_login', 10, 2);
add_action( 'admin_enqueue_scripts', 'biz_portal_add_scripts' );
add_action( 'admin_init', 'biz_portal_redirect_admin' );
register_activation_hook(__FILE__, 'biz_portal_install');
register_activation_hook(__FILE__, 'biz_portal_rewrite_flush');
register_deactivation_hook(__FILE__, 'biz_portal_uninstall');

wp_register_script('biz_portal_admin.js', plugins_url('assets/admin.js', __FILE__));


apply_filters ( 'login_url', site_url('signin'), '');

/**
 * Redirect normal users (subscribers) to dashboard if they try to access admin panel.
 *
 */
function biz_portal_redirect_admin()
{
	if ( ! current_user_can( 'edit_posts' ) ){
		wp_redirect( site_url(get_option('member_login_page')) );
		exit;		
	}
}

/**
 * Add scripts and styles for the plugin
 */
function biz_portal_add_scripts()
{
    wp_enqueue_script('biz_portal_admin.js');
}


/**
 * Return table prefix for wordpress db
 * 
 * @return string
 */
function biz_portal_get_table_prefix()
{
    global $wpdb;
    return $wpdb->prefix . 'portal_';
}

/**
 * Returns the default country given for smes
 * 
 * @return int 
 */
function biz_portal_get_option_sme_default_country()
{
    return get_option('sme_default_country');
}


////////////////////////////////////////////////////////////////////////////////
//
// NODES -----------------------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////

/**
 * Find categories for nodes
 *
 * @param bool $load_user_value
 * @param string $type Type from BP_Node::NODE_TYPE_* if any
 * @return array
 */
function biz_portal_node_get_categories($load_user_value = false, $type = '')
{
    global $wpdb;
    $BP_Repo_Nodes = new BP_Repo_Nodes($wpdb, biz_portal_get_table_prefix());
    $results = $BP_Repo_Nodes->find_categories($load_user_value = false, $type = '');
    return $results;
}

/**
 * Find nodes based on types
 * 
 * @param string $node_type
 * @param int $category
 * @param string $search_term
 * @param string $search_type ALPHABET | FULL
 * @param int $count
 * @param int $offset
 */
function biz_portal_node_get_list($node_type, $category = 0, $search_term = '', $search_type = 'FULL', $company_id = 0, $count = 0, $offset = 0)
{
    global $wpdb;
    $user_ID = get_current_user_id();
    $BP_Repo_Nodes = new BP_Repo_Nodes($wpdb, biz_portal_get_table_prefix());
    $where = array();
    if ($category > 0) $where['category_id'] = $category;
    if (!empty($search_term))
    {
        if ($search_type === 'FULL') {
            $where['title'] = $search_term;
            $where['body'] = $search_term;
        }
        else if ($search_type === 'ALPHABET') {
            $where['title'] = $search_term;
        }
    }
    if ($company_id > 0) {
        $where['company_id'] = $company_id;
    }
    
    if ((biz_portal_get_current_company_id() != $company_id) && is_super_admin( $user_ID) != true  && is_super_admin( $user_ID) != 1){
        $where['active'] = 1;
    }    
    $result = $BP_Repo_Nodes->find_nodes($node_type, $where, $count, $offset);
    $total = $BP_Repo_Nodes->count_nodes($node_type, $where);
    
    $ViewModel_Nodes = new ViewModel_Nodes();
    $ViewModel_Nodes->nodes = $result;
    $ViewModel_Nodes->total = $total;
    $ViewModel_Nodes->count = $count;
    $ViewModel_Nodes->offset = $offset;
    
    return $ViewModel_Nodes;
}

//biz_portal_node_email(63, 95);

/**
 * Send email to admin after node is created
 * 
 * @param unknown_type $node_id
 * @param unknown_type $company_id
 * @throws Exception
 */
function biz_portal_node_email($node_id, $company_id)
{
    global $wpdb;
    $BP_Repo_Nodes = new BP_Repo_Nodes($wpdb, biz_portal_get_table_prefix());
    $company = biz_portal_get_company($company_id);
    if ($company) {
        $company_full = biz_portal_load_company_relations($company);
        $contact_keys = array_keys($company_full->contacts);
        try {
            $email = get_option('admin_email');
            $tempalte = _biz_portal_get_email_template('NODE_CREATED');
            if ($tempalte) {
                $subject = $tempalte->title;
                $body = $tempalte->email_text;
            }
            $node = $BP_Repo_Nodes->find_node_by_id($node_id);
            $body_replaced = preg_replace(array('/@FROMCOMPANY/', '/@CONTENTTITLE/', '/@CONTENTURL/'),
                    array(esc_html($company_full->company_name),
                            esc_html($node->title),
                            admin_url('admin.php?page=business-portal-resource&action=view&rcs_id=' . $node_id)), $body);
            if (!EMAIL_DISABLED)
                $res = wp_mail($email, $subject, $body_replaced);
        }
        catch (Exception $ex) {
            throw $ex;
        }
    }
    return $res;
}



function biz_portal_get_video_duration($type ,$url)
{
    if($type ==="youku"){
        $time="0.0";
        return $time;
        
    }elseif($type ==="youtube"){
         # get video id from url
          $urlQ = parse_url( $url, PHP_URL_QUERY );
          parse_str( $urlQ, $query );

          # YouTube api v2 url
          $apiURL = 'http://gdata.youtube.com/feeds/api/videos/'. $query['v'] .'?v=2&alt=jsonc';

          # curl options
          $options = array(
            CURLOPT_URL  => $apiURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 5 );

          # connect api server through cURL
          $ch = curl_init();
          curl_setopt_array($ch, $options);
          # execute cURL
          $json = curl_exec($ch) or die( curl_error($ch) );
          # close cURL connect
          curl_close($ch);

          # decode json encoded data
          if ($data = json_decode($json)){
                  $datas=$data->data;
                  $bsec=($datas->duration)% 60;
                  $bmin =($datas->duration- $bsec)/60;
                  $duration =$bmin.":".$bsec;
            return $duration ;
          }
        
        
    }
    
}
/**
 * Send email to user once the node is activated
 * 
 * @param unknown_type $node_id
 */
function biz_portal_node_activate_email($node_id)
{
    global $wpdb;
    $BP_Repo_Nodes = new BP_Repo_Nodes($wpdb, biz_portal_get_table_prefix());
    $node = $BP_Repo_Nodes->find_node_by_id($node_id);
    $company = biz_portal_get_company($node->company_id);    
    if ($company) {
        $company_full = biz_portal_load_company_relations($company);
        $contact_keys = array_keys($company_full->contacts);
        $email = $company_full->contacts[$contact_keys[0]]->email;
        try {
            $tempalte = _biz_portal_get_email_template('NODE_ACTIVATED');
            if ($tempalte) {
                $subject = $tempalte->title;
                $body = $tempalte->email_text;
                $body_replaced = preg_replace(array('/@CONTACTNAME/', '/@CONTENTTITLE/', '/@CONTENTURL/'),
                        array(esc_html($company_full->contacts[$contact_keys[0]]->contact_person),
                                esc_html($node->title),
                                site_url() . '/dashboard/view-company?id=95&res_id=' . $node_id), $body);
                if (!EMAIL_DISABLED)
                    $res = wp_mail($email, $subject, $body_replaced);
            }
        }
        catch (Exception $ex) {
            throw $ex;
        }
    }
    return $res;
}

/**
 * Load node by its id
 * 
 * @param int $node_id
 * @return BP_Node|bool
 */
function biz_portal_get_node($type, $node_id, $company_id) 
{
    global $wpdb;
    $BP_Repo_Nodes = new BP_Repo_Nodes($wpdb, biz_portal_get_table_prefix());
    if (biz_portal_get_current_company_id() == $company_id)
        $results = $BP_Repo_Nodes->find_nodes($type, array('id' => $node_id, 'company_id' => $company_id), 1);
    else 
        $results = $BP_Repo_Nodes->find_nodes($type, array('id' => $node_id, 'company_id' => $company_id, 'active' => 1), 1);
    if (isset($results[$node_id])) {
        $BP_Node = $results[$node_id];
        return $BP_Node;
    }
    return false;
}

/**
 * Change the state of a node
 * 
 * @param int $node_id
 * @param int $state
 * @return boolean
 */
function biz_portal_node_change_state($node_id, $state)
{
    if (!is_numeric($node_id) || !is_numeric($state)) return false;
    global $wpdb;
    $res = $wpdb->update(_biz_portal_get_table_name(BP_Node::$table_name), 
            array('active' => $state), array('id' => $node_id), array('%d'), array('%d'));
    
    if ($state == 1 && $res > 0) {
        biz_portal_node_activate_email($node_id);
    }
    return $res;
}


////////////////////////////////////////////////////////////////////////////////
//
// ACTIONS ---------------------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////


/**
 * Login redirect hook
 * 
 * @global type $user
 * @param resource $redirect_to URL resouce
 * @param resource $request Request resource
 * @param resource $user WP User object
 * @return resource
 */
function biz_portal_login_redirect($redirect_to, $request, $user)
{
    //is there a user to check?
    global $user;
    require_once( ABSPATH . 'wp-includes/pluggable.php' );
    $g_user = new Groups_User($user->ID);
    $g_groups = $g_user->groups;
    //$member_array = biz_portal_get_dashboard_members();

    $welcome_page = get_option('member_login_page');
    if ($welcome_page)
        $redirect_to = site_url() . $welcome_page;
    
    // Check if first time login
    $is_new_user = (int)get_user_meta($user->ID, '_new_user', 1);
    if ($is_new_user == 1) {
        update_user_meta( $user->ID, '_new_user', '0' );
    }  
    
    
    /*if ($is_new_user == 1 && get_option('welcome_page'))
        $redirect_to = get_permalink(get_option('welcome_page')); 
    */
    return $redirect_to;
}

function biz_portal_init()
{
    ob_start();
    add_action('admin_menu', 'biz_portal_admin_submenu_page');   
}

/**
 * Capture last login, This function is called by the action 'login'
 * @param string $login
 * @param WP_User $user
 */
function biz_portal_capture_last_login($login, $user) {
    global $user_ID;
    $user = get_user_by( 'login', $login );
    
    $last_login = get_user_meta($user->ID, 'bp_last_login', true);
    $company = biz_portal_get_company_by_uid($user->ID);
   // error_log('company_id ' . $company->id . ' ---- USER ID : ' . $user->ID . ' -- last login . ' . $last_login , 0);
    
    
    if ($last_login && $company) {
        //error_log("add score with last login", 0);
        $score_interval = (int)get_option('login_score_interval');
        if ($score_interval)
        {
            // Add score if the interval is reached between current and
            // last login
            $interval_seconds = $score_interval * 60 * 60;
            if (time() >= ($last_login + $interval_seconds))
            {
                biz_portal_add_score(BP_Score::SCORE_LOGIN, $company->id);
            }
        }
    }
    else if ($company) {
        biz_portal_add_score(BP_Score::SCORE_LOGIN, $company->id);
    }
        
    update_user_meta( $user->ID, 'bp_last_login', time() );
}


////////////////////////////////////////////////////////////////////////////////
//
// DB LISTS AND VALUES ---------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////

/**
 * Return a list for countries (wpdb returned array of all countries)
 * 
 * @return array
 * @example Array
 *   (
 *       [0] => Array
 *           (
 *               [id] => 1
 *               [country_code] => US
 *               [country_name] => United States
 *           )
 *
 *       [1] => Array
 *           (
 *               [id] => 2
 *               [country_code] => CA
 *               [country_name] => Canada
 *           )
 *   )
 */
function biz_portal_get_country_list()
{
    global $wpdb;
    $sql = "SELECT * FROM " . _biz_portal_get_table_name('countries');
    $result = $wpdb->get_results($sql, ARRAY_A);
    return $result;
}

/**
 * Return a list of countries for filtering purpose
 * @return array
 */
function biz_portal_get_filter_country_list()
{
    global $wpdb;
    $result_list=get_option('filter_country_list');
    $result_array = array_map('trim',explode(PHP_EOL, $result_list));
    $result_count=count($result_array);
    $cc_arr= array();
    foreach ($result_array as $value) {
        $exploded_arr = array_map('trim',explode('|', $value));
        $cc_arr[]="'".$exploded_arr[0]."'";
        
    }
     $sql  = "SELECT * FROM " . _biz_portal_get_table_name('countries');
     $sql .= " WHERE country_code IN (".implode(',',$cc_arr).")" ;
     $country_list = $wpdb->get_results($sql, ARRAY_A);
     
     return $country_list;

//    array(
//            array('id' => 192, 'country_code' => 'SG', 'country_name' => 'Singapore'),
//            array('id' => 96, 'country_code' => 'HK', 'country_name' => 'Hong Kong'),
//    );
}

/**
 * Return true or false logged user's Country(Getting though ip) in mentioned country list of backedn 
 *
 */
function biz_portal_country_is_exceptional($default=null)
{
    global $wpdb;
    if($default !=null){
        $ip=$default;
    }elseif ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];        
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {$ip = $_SERVER['REMOTE_ADDR'];}
    
    $long = ip2long($ip);
 
    $sql  = "SELECT * FROM " . _biz_portal_get_table_name('geo_ips');
    $sql .= " WHERE ".$long." BETWEEN start_long AND end_long LIMIT 1";

    $result = $wpdb->get_row($sql, ARRAY_A); 
   
    $country_ids=get_option('ip_country_ids');
    $ids_array = array_map('trim',explode(PHP_EOL, $country_ids));
    $ids_list=array();
    
    foreach ($ids_array as $value) {
        $exploded_arr = array_map('trim',explode('|', $value));
        $ids_list[]=$exploded_arr[0];
    }
    
    
    if (in_array($result['cc'], $ids_list)) {
        return true;
    }else{
        return false;
    }
    
}

/**
 * Select a specified country given by country id from the wpdb loaded array list 
 * of country database
 *
 * @param int $country_id
 * @param array $country_list
 * @return array Array of country fields in a single row
 */
function biz_portal_select_country($country_id, $country_list)
{
    foreach ($country_list as $country)
    {
        if ($country['id'] == $country_id)
            return $country;
    }
    return false;
}

/**
 * Select all business types (wpdb returned array of all business types)
 *
 * @param bool $enable_user_value whether to return the user added values
 * @return array 
 * @example Array
 *   (
 *       [0] => Array
 *           (
 *               [id] => 1
 *               [type_text] => Service
 *               [is_user_value] => 0
 *           )
 *
 *       [1] => Array
 *           (
 *               [id] => 2
 *               [type_text] => Manufacturing
 *               [is_user_value] => 0
 *           )
 *   )
 */
function biz_portal_get_business_types_list($enable_user_value = false)
{
    global $wpdb;
    $sql = "SELECT * FROM " . _biz_portal_get_table_name('biz_types');
    if (!$enable_user_value)
        $sql .= " WHERE is_user_value = 0";

    $result = $wpdb->get_results($sql, ARRAY_A);
    return $result;   
}

/**
 * Select all industries (wpdb returned array of all industries)
 *
 * @param bool $enable_user_value whether to return the user added values
 * @return array 
 * @example Array
 *    (
 *        [0] => Array
 *           (
 *               [id] => 1
 *               [ind_name] => Oil & Gas
 *               [is_user_value] => 0
 *           )
 *
 *       [1] => Array
 *           (
 *               [id] => 2
 *               [ind_name] => Telecommunications
 *               [is_user_value] => 0
 *           )
 *   )
 */
function biz_portal_get_industries_list($enable_user_value = false, $user_value = 0)
{
    global $wpdb;
    $sql = "SELECT * FROM " . _biz_portal_get_table_name('industries');
    if ($enable_user_value && $user_value > 0)
        $sql .= " WHERE is_user_value = " . intval($user_value);
    else
        $sql .= " WHERE is_user_value = 0";

    $result = $wpdb->get_results($sql, ARRAY_A);
    return $result; 
}

/**
 * Select all business services (wpdb returned array of all business services)
 *
 * @param bool $enable_user_value whether to return the user added values
 * @return array 
 * @example Array
 *   (
 *       [0] => Array
 *           (
 *               [id] => 1
 *               [service_name] => Accounting
 *               [is_user_value] => 0
 *           )
 *
 *       [1] => Array
 *           (
 *               [id] => 2
 *               [service_name] => Legal
 *               [is_user_value] => 0
 *           )
 *   )
 */
function biz_poratal_get_biz_services_list($enable_user_value = false)
{
    global $wpdb;
    $sql = "SELECT * FROM " . _biz_portal_get_table_name('biz_services');
    if (!$enable_user_value)
        $sql .= " WHERE is_user_value = 0";

    $result = $wpdb->get_results($sql, ARRAY_A);
    return $result;
}



////////////////////////////////////////////////////////////////////////////////
//
// PRIVATE MESSAGES ------------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////


/**
 * Send private message to company
 * 
 * @param int $to_company_id
 * @param string $message
 * @param int $reply_to Reply to message ID
 */
function biz_portal_pm_send($to_company_id, $message, $reply_to = 0)
{
    global $wpdb;
    
    $current_company_id = biz_portal_get_current_company_id();
    
    $BP_PrivateMessage = new BP_PrivateMessage();
    $BP_PrivateMessage->from_company_id = $current_company_id;
    $BP_PrivateMessage->message = $message;
    $BP_PrivateMessage->reply_to_msg_id = $reply_to;
    $BP_PrivateMessage->to_company_id = $to_company_id;
    
    $BP_Repo_Message = new BP_Repo_Messages($wpdb, biz_portal_get_table_prefix());
    $res_saved = $BP_Repo_Message->send_message($BP_PrivateMessage);
    
    $message_id = $wpdb->insert_id;
    
    if ($res_saved && $message_id)
    {
        $BP_Repo_Companies = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix());
        $current_company = biz_portal_get_company($current_company_id);
        $to_company = biz_portal_get_company($to_company_id);
        
        $to_contact = $BP_Repo_Companies->find_first_contact($to_company_id);
        
        if ($reply_to == 0)
            $tempalte = _biz_portal_get_email_template(PRIVATE_MESSAGE_NEW);
        else 
            $tempalte = _biz_portal_get_email_template(PRIVATE_MESSAGE_REP);
        
        if ($tempalte) {
            $email = $to_contact->email;
            $subject = $tempalte->title;
            $body = $tempalte->email_text;
            $body_replaced = preg_replace(array('/@CONTACTNAME/', '/@FROMCOMPANY/', '/@MESSAGE/', '/@LINKURL/'),
                    array(esc_html($to_contact->contact_person),
                            $current_company->company_name,
                            htmlentities($message),
                            biz_portal_get_pm_url($message_id)), $body);
            if (!EMAIL_DISABLED)
                $res_mail = wp_mail($email, $subject, $body_replaced);
        }
    }
    
    return $res_saved;
}

/**
 * Return the private message link
 * 
 * @param int $pm_id
 * @return string
 */
function biz_portal_get_pm_url($pm_id)
{
    return site_url('dashboard/messages');
}

/**
 * Mark the private message as read
 * 
 * @param int $message_id
 * @return bool
 */
function biz_portal_pm_mark_read($message_id)
{
    global $wpdb;
    $BP_Repo_Message = new BP_Repo_Messages($wpdb, biz_portal_get_table_prefix());
    $res = $BP_Repo_Message->mark_as_read($message_id,  biz_portal_get_current_company_id());
    
    return $res;
}


/**
 * Returns the count of unread messages for the current company
 * 
 * @return int|null
 */
function biz_portal_pm_new()
{
    global $wpdb;
    $current_company_id = biz_portal_get_current_company_id();
    $BP_Repo_Message = new BP_Repo_Messages($wpdb, biz_portal_get_table_prefix());
    
    $count = $BP_Repo_Message->count_new_messages($current_company_id);
    return $count;
}

/**
 * Find Private message by id
 * 
 * @param int $id
 */
function biz_portal_pm_find_by_id($id)
{
    global $wpdb;
    $BP_Repo_Message = new BP_Repo_Messages($wpdb, biz_portal_get_table_prefix());
    $results = $BP_Repo_Message->search_message(array('id' => $id), array('%d'), 1);
    
    if (count($results->messages) > 0 && isset($results->messages[$id])) {
        return $results->messages[$id];
    }
    else 
        return false;
}


////////////////////////////////////////////////////////////////////////////////
//
// USER ------------------------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////

/**
 * Create a portal user email address as username and provided with dynamic passwords
 *
 * @param string $email
 * @param int $company_id
 * @throws Exception
 * @return bool|string  Return password on success or false on failure
 */
function biz_portal_create_user($email, $company_id)
{
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$email) {
        throw new Exception("Email is not valid");        
    }

    $username_exists = username_exists($email);
    if (!$username_exists) {
        $username_exists = email_exists($email);
    }
    if ($username_exists) {
        throw new Exception("User account was not created. User name/   email already registered.");        
    }

    $alphabet = 'abcdefghijkmnorstuwxyzABCDEFGHJKLMNOPQRSTUWXYZ0123456789';
    $pass = '';
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass .= $alphabet[$n];
    }

    // to check if first login
    // $logincontrol = get_metadata('user', $user->ID, '_new_user');
    // after checking update it
    // update_user_meta( $user->ID, '_new_user', '0' );

    $user_id = wp_create_user($email, $pass, $email);
    if (!is_wp_error($user_id) && $user_id > 0)
    {
        add_user_meta( $user_id, '_new_user', '1' );
        biz_portal_set_uid_to_company($user_id, $company_id);
        return $pass;
    }

    return false;
}

/**
 * Return list of groups as wpdb result object
 * 
 * @return resource
 */
function biz_portal_get_groups()
{
    global $wpdb;
    if (!function_exists('_groups_get_tablename'))
    {
        die('Plugin group is not installed. Please install it. ' .
                '<a href="http://www.itthinx.com/plugins/groups">http://www.itthinx.com/plugins/groups</a>');
    }
    $group_table = _groups_get_tablename('group');

    $result = $wpdb->get_results("SELECT * FROM {$group_table}");
    return $result;
}

////////////////////////////////////////////////////////////////////////////////
//
// COMPANIES -------------------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////

/**
 * Load the company name and id as hash table
 * 
 * @param array $ids
 * @return multitype:|Ambigous <mixed, NULL, multitype:, multitype:multitype: , multitype:unknown >
 */
function biz_portal_get_company_hash_table(array $ids)
{
    global $wpdb;
    if (count($ids) == 0) return array();
    
    $ids_in = implode(',', $ids);
    $sql = "SELECT id, company_name FROM " . _biz_portal_get_table_name(BP_Company::$table_name) . " WHERE id in (" . $ids_in . ")";
    
    $results = $wpdb->get_results($sql, ARRAY_A);
    
    if ($results)    
        return $results;
    else
        return array();
}

/**
 * Send email once the company is activated by administrator
 * 
 * @param int $company_id
 * @throws Exception
 */
function biz_portal_trigger_company_activated($company_id)
{
    global $wpdb;
    // set activated companies terms accepted into 2 so that they should do it again.
    $data = array('terms_accepted' => 2);
    $where = array('id' => $company_id);
    $res = $wpdb->update(_biz_portal_get_table_name(BP_Company::$table_name), $data, $where, 
            array('%d'), array('%d'));    
    // 
    $company = biz_portal_get_company($company_id);
    if ($company) {
        $company_full = biz_portal_load_company_relations($company);                    
        $contact_keys = array_keys($company_full->contacts);
        try {
            $email = $company_full->contacts[$contact_keys[0]]->email;
            $password = biz_portal_create_user($email, $company_id);
            if ($password && get_option('enable_account_activation_email') == 1) {
                $tempalte = _biz_portal_get_email_template('WELCOME');
                if ($tempalte) {
                    $subject = $tempalte->title;
                    $body = $tempalte->email_text;
                    $body_replaced = preg_replace(array('/@CONTACTNAME/', '/@CONTACTEMAIL/', '/@PASSWORD/', '/@LOGINURL/'), 
                         array(esc_html($company_full->contacts[$contact_keys[0]]->contact_person), 
                            esc_html($email), 
                            htmlentities($password),
                            site_url() . '/signin/'), $body);
                    if (!EMAIL_DISABLED)
                        $res = wp_mail($email, $subject, $body_replaced);
                }
            }
        }
        catch (Exception $ex) {
            throw $ex;            
        }
    }
}

/**
 * Send email to client once he sign up 
 * 
 * @param BP_Company $company Fully loaded company object send from registration
 */
function biz_portal_trigger_company_create(BP_Company $company)
{
    $contact_keys = array_keys($company->contacts);
    try {
        $email = $company->contacts[$contact_keys[0]]->email;
        $tempalte = _biz_portal_get_email_template('SIGNUP');
        if ($tempalte) {
            $subject = $tempalte->title;
            $body = $tempalte->email_text;
            $body_replaced = preg_replace(array('/@CONTACTNAME/', '/@SITENAME/'), 
                    array($company->contacts[$contact_keys[0]]->contact_person, get_bloginfo('name')), $body);
            if (!EMAIL_DISABLED) {
                $res = wp_mail($email, $subject, $body_replaced);
                
                // send mail to admin
                $admin_email = get_bloginfo('admin_email');
                $admin_template = _biz_portal_get_email_template('NEW_REGISTRATION');
                if ($admin_template) {
                    
                    $url = site_url('wp-admin') . '/admin.php?page=admin-list-companies&local_page=view&company_id=' . $company->id;
                    $admin_body_replaced = preg_replace(array('/@COMPANYNAME/', '/@URL/'),
                            array($company->company_name, $url), $admin_template->email_text);
                    
                    wp_mail($admin_email, $admin_template->title, $admin_body_replaced);
                }
            }
        }
    }
    catch (Exception $ex) {
        throw $ex;
    }
}

/**
 * Update or create new company if not exist
 * 
 * @param \BP_Company $company
 * @return bool
 */
function biz_portal_update_company(\BP_Company $company)
{
    global $wpdb;
    $repo = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix(), BIZ_PORTAL_SAVE_NEW_INDUSTRY);
    $result = $repo->company_update($company);
    return $result;
}

/**
 * Set user ID to company
 *
 * @param int $uid
 * @param int $company_id
 */
function biz_portal_set_uid_to_company($uid, $company_id)
{
    global $wpdb;
    $data = array('user_id' => $uid);
    $wpdb->update(_biz_portal_get_table_name(BP_Company::$table_name),
        $data, array('id' => $company_id), array('%d'), array('%d'));
}

/**
 * Set the company status
 *
 * @param int $company_id
 * @param int $active
 * @return bool
 */
function biz_portal_change_company_state($company_id, $active)
{
    global $wpdb;
    $repo = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix(), BIZ_PORTAL_SAVE_NEW_INDUSTRY);
    return $repo->change_state($company_id, $active);
}


/**
 * Search and returns companies as company object, the linked objects
 * will not be populated and those have to be fetched seperatedly one by one.
 * and the search is made only at main table level.
 *
 * @param array $where
 * @param array $format
 * @param int $count
 * @param int $offset
 * @return ViewModel_Companies 
 */
function biz_portal_search_companies(array $where = array(), array $format = array(), $count = 0, $offset = 0)
{
    global $wpdb;
    $repo = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix(), BIZ_PORTAL_SAVE_NEW_INDUSTRY);
    return $repo->search_companies($where, $format, $count, $offset);
}

/**
 * Find the company by specified company id
 *
 * @param int $user_id
 * @return BP_Company | bool
 */
function biz_portal_get_company($company_id)
{
    $company_vm = biz_portal_search_companies(array('id' => $company_id), array('%d'), 1);
    if ($company_vm->total > 0)
        return $company_vm->companies[$company_id];
    else
        return false;
}

/**
 * Delete a company and its owner (User)
 *
 * @param int $company_id
 */
function biz_portal_delete_company($company_id)
{
    global $wpdb;
    $repo = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix(), BIZ_PORTAL_SAVE_NEW_INDUSTRY);
    $company = biz_portal_get_company($company_id);
    if ($company->user_id) {
        wp_delete_user($company->user_id);
    }
    return $repo->delete($company_id);
}

/**
 * Find the company that belongs to user and return a company object
 *
 * @param int $user_id
 * @return BP_Company | bool
 */
function biz_portal_get_company_by_uid($user_id)
{
    if (!$user_id > 0)
        return null;
    
    $company_vm = biz_portal_search_companies(array('user_id' => $user_id), array('%d'), 1);
    if ($company_vm->total > 0) {
        $keys = array_keys($company_vm->companies);
        return $company_vm->companies[$keys[0]];
    }
    else
        return false;
}

/**
 * 
 * @param BP_Industry $industry
 */
function biz_portal_update_industry(BP_Industry $industry)
{
    global $wpdb;
    $repo = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix(), BIZ_PORTAL_SAVE_NEW_INDUSTRY);
    $repo->industry_update($industry);
}

/**
 * Load the company object with its relational objects
 *
 * @param BP_Company $company
 * @return BP_Company
 */
function biz_portal_load_company_relations(BP_Company $company)
{
    global $wpdb;
    $repo = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix(), BIZ_PORTAL_SAVE_NEW_INDUSTRY);
    return $repo->load_company_relations($company);
}

/**
 * Check if the user has any previousely registered company or
 * user has any registered user account with the given email address.
 *
 * @param string $email
 * @throws Exception
 * @return BP_Company|null
 */
function biz_portal_get_company_by_email($email)
{
    global $wpdb;
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$email) {
        throw new Exception("Email is not valid");        
    }

    /*$username_exists = username_exists($email);
    if ($username_exists) {
        return true;
    }*/

    $repo = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix(), BIZ_PORTAL_SAVE_NEW_INDUSTRY);
    return $repo->find_company_by_user_email($email);
}

/**
 * Get the company ID for the current user logged in
 */
function biz_portal_get_current_company_id()
{
    if (!is_user_logged_in())
        return 0;
    
    $uid = get_current_user_id();
    if ($uid > 0) {
        $company = biz_portal_get_company_by_uid($uid);
        return $company->id;
    }
    
    return 0;
}

/**
 * Load the company profile object 
 * 
 * @param unknown $company_id
 * @return BP_CompanyProfile | null
 */
function biz_portal_get_company_profile($company_id)
{
	global $wpdb;
	$repo = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix());
	return $repo->get_company_profile($company_id);
}


/**
 * Counts the company by type and needs
 * 
 * @param string $type
 * @param string $needs
 */
function biz_portal_count_company($type = '', $needs = '')
{
    if (empty($type) && empty($needs)) return;
    global $wpdb;
    $count = 0;
    $repo = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix());
    $filter = new BP_Company_Filter();
    
    switch ($type) {
        case BP_MemberType::TYPE_INTL:
            $filter->member_type = BP_MemberType::TYPE_INTL;
            break;
        case BP_MemberType::TYPE_SME:
            $filter->member_type = BP_MemberType::TYPE_SME;
            break;
        case BP_MemberType::TYPE_NGO:
            $filter->member_type = BP_MemberType::TYPE_NGO;
            break;
            
    }      
    
    switch ($needs) {
        case BP_BizNeedType::PARTNER:
            $filter->bool_biz_need_partner_in = 1;
            break;
        case BP_BizNeedType::NGO_SUPPORT_SERVICE:
            $filter->bool_biz_need_ngo_supp_serv = 1;
            break;
        case BP_BizNeedType::PROVIDE_SERVICE:
            $filter->bool_biz_give_service = 1;
            break;
        case BP_BizNeedType::PROVIDE_INVEST:
            $filter->bool_biz_give_invest = 1;
            break;
    }
    
    $count = $repo->filter_companies_count($filter);
    return $count;
}

function biz_portal_find_company_by_email_simple($email)
{
    global $wpdb;
    $sql = "SELECT DISTINCT c.id, c.company_name FROM " . _biz_portal_get_table_name(BP_Company::$table_name) . " c ".
        "INNER JOIN " . _biz_portal_get_table_name(BP_Contact::$table_name) . " contact ON contact.company_id = c.id " .
        "WHERE contact.email = '%s'";
    $sql = sprintf($sql, $email);
    
    return $wpdb->get_row($sql, OBJECT);
}


////////////////////////////////////////////////////////////////////////////////
//
// FILES -----------------------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////

/**
 * Save file object and returns the file id if success
 * 
 * @param BP_File $file
 * @return int|bool
 */
function biz_portal_save_file(BP_File $file)
{
    global $wpdb;
    $BP_Repo_Files = new BP_Repo_Files($wpdb, biz_portal_get_table_prefix());
    return $BP_Repo_Files->save_file($file);
}

/**
 * Add file usage
 * 
 * @param int $file_id
 * @return bool
 */
function biz_portal_add_file_usage($file_id)
{
    global $wpdb;
    if ($file_id > 0) {        
        $BP_Repo_Files = new BP_Repo_Files($wpdb, biz_portal_get_table_prefix());
        return $BP_Repo_Files->add_file_usage($file_id);
    }
    return false;
}

/**
 * Remove file usage
 *
 * @param int $file_id
 * @return bool
 */
function biz_portal_remove_file_usage($file_id)
{
    global $wpdb;
    if ($file_id > 0) {
        $BP_Repo_Files = new BP_Repo_Files($wpdb, biz_portal_get_table_prefix());
        return $BP_Repo_Files->remove_file_usage($file_id);
    }
    return false;
}


/**
 * Returns the file object given by id or null
 * 
 * @param int $file_id
 * @return BP_Favourite
 */
function biz_portal_load_file($file_id)
{
    global $wpdb;
    $BP_Repo_Files = new BP_Repo_Files($wpdb, biz_portal_get_table_prefix());
    return $BP_Repo_Files->load_file($file_id);
}


/**
 * Get full url to the file
 * 
 * @param int $file_id
 * @param int $thumb
 * @param int $download
 * @return string
 */
function biz_portal_get_file_url($file_id, $thumb = 0, $download = 0, $load_default = 0)
{
    $url = site_url('file_download/') . '?file_id=' . $file_id;
    if ($thumb == 1) {
        $url .= '&thumb=1';
    }
    if ($download == 1) {
        $url .= '&download=1';
    }
    if ($load_default == 1) {
        $url .= '&default=1';
    }
    return $url;
}


////////////////////////////////////////////////////////////////////////////////
//
// SCORES ----------------------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////


/**
 * Get a single score object for the company ID
 *
 * @param int $company_id
 * @return BP_Company
 */
function biz_portal_get_score($company_id)
{
    global $wpdb;
    $sql = "SELECT * FROM " . _biz_portal_get_table_name(BP_Score::$table_name) . " WHERE company_id = %d";
    $sql = sprintf($sql, $company_id);
    $result = $wpdb->get_row($sql, ARRAY_A);

    $score = new BP_Score();
    $score->company_id = $company_id;
    if ($result) {
        $score->company_id = $result['company_id'];
        $score->scores = $result['scores'];
    }
    
    return $score;
}

/**
 * Add score for companies
 *
 * @param string $score_type
 * @param int $company_id
 * @return mixed
 */
function biz_portal_add_score($score_type, $company_id)
{
    global $wpdb;    
    //error_log($score_type . ' - ' . $company_id, 0);
    if (!empty($score_type) && $company_id > 0)
    {        
        $score_value = get_option($score_type);
        $score_object = biz_portal_get_score($company_id);
        $score_object->add_score($score_value);
        biz_portal_save_score($score_object);
        return $score_object;
    }
}

/**
 * Save the score object
 * @param BP_Score $score
 */
function biz_portal_save_score(BP_Score $score)
{
    global $wpdb;
    // Check if exists
    $counts = $wpdb->get_var(
        $wpdb->prepare("SELECT COUNT(*) FROM " . _biz_portal_get_table_name(BP_Score::$table_name) . " WHERE company_id = %d", 
        $score->company_id)
    );

    if ($counts > 0)
    {
        $wpdb->update(_biz_portal_get_table_name(BP_Score::$table_name), 
            $score->to_array(), 
            array('company_id' => $score->company_id), $table_def_scores, array('%d'));
    }
    else {
        $wpdb->insert(_biz_portal_get_table_name(BP_Score::$table_name), 
            $score->to_array(),
            $table_def_scores);
    }
}

////////////////////////////////////////////////////////////////////////////////
///
/// Advertesement -------------------------------------------------------------
///
/////////////////////////////////////////////////////////////////////////////////

/**
 * Get Advertisement filter with id's
 *
 * @return intiger
 */
function biz_portal_get_advertisement($ads_type, $id_list = '')
{
    global $wpdb;
    $select_sql_query = " FROM " . _biz_portal_get_table_name('advertisements');
    $select_sql = "SELECT * " . $select_sql_query;
    $select_sql_where =" WHERE ads_type='$ads_type' ";
        if($id_list){
            $notin_list=implode(",",$id_list);
            $select_sql_limit =" AND `image_id` NOT IN ($notin_list)";
        }else{$select_sql_limit ="";}
    
    $select_sql_count = "SELECT COUNT(*) " . $select_sql_query . $select_sql_where . $select_sql_limit;
    $select_count = $wpdb->get_var($select_sql_count);
    $random_raw =rand(0,(int)$select_count-1);
    $select_sql_limit .= " LIMIT $random_raw, 1";
    $select_sql_result = $select_sql . $select_sql_where . $select_sql_limit;
    $select_result = $wpdb->get_row($select_sql_result, ARRAY_A);
    
    $hydrator = new BP_Hydrator();
    $advertisement = new BP_Advertisement();
    
    if (is_array($select_result)) {
        $hydrator->hydrate($advertisement, $select_result);
        return $advertisement;
    }
    else {
        return false;
    }
}

/**
 * add advertisment view time's 
 * @input id-advertisment id
 * @return intiger
 */
function biz_portal_add_ads_view($add_id)
{
    global $wpdb;
    if($add_id != null && $add_id > 0){
        
    $select_sql =" FROM " . _biz_portal_get_table_name('ads_clicks');
    $select_sql .=" WHERE ads_id= $add_id ";
    $select_count = $wpdb->get_var("SELECT count(*) ".$select_sql);
        if($select_count==='0' || $select_count === 'null'){
            $wpdb->insert(_biz_portal_get_table_name('ads_clicks'),
                    array('ads_id' =>$add_id,'clicks_count' => 0,'views_count'=>1));
        }else{
            $result =$wpdb->get_row("SELECT * ".$select_sql);
        
                $wpdb->update(_biz_portal_get_table_name('ads_clicks'),
                array('views_count' => (int)$result->views_count +1),
                array('ads_id' => $add_id),array('%d'));
        }
        return true;
    }
     
    
}

////////////////////////////////////////////////////////////////////////////////
//
// FORM FUNCTIONS  -------------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////


function biz_portal_form_get_ngo_services()
{
    $options = get_option('biz_forms_ngo_services');
    if (is_array($options)) {
        $ngo_services=array_keys($options);
        return $ngo_services;
    }
    else {
        return false;
    }
}

function biz_portal_form_get_ngo_biz_types()
{
    $options = get_option('biz_forms_ngo_types');
    if (is_array($options)) {
        $ngo_types=array_keys($options);
        return  $ngo_types;
    }
    else {
        return false;
    }
}



////////////////////////////////////////////////////////////////////////////////
//
// STATS  ----------------------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////

function biz_portal_add_visit($visit_page_type, $value = 0)
{    
    if (ENABLE_VISIT_LOGS == false) return;
    
    global $wpdb;
        
    if ($visit_page_type > 0) {
        $cookie_name = 'company_id_' . $visit_page_type . "_" . $value;
        if (!isset($_COOKIE[$cookie_name])) {
            setcookie($cookie_name, 1, time() + 60, "/");
            $data = array(
                    'page_type_id' => $visit_page_type,
                    'page_value' => $value,
                    'user_ip' => ip2long(_biz_portal_get_user_ip()),
            );
            $wpdb->insert('wp_portal_visits', $data, array('%d', '%d', '%d'));
        }
    }
}



////////////////////////////////////////////////////////////////////////////////
//
// PRIVATE FUNCTIONS  ----------------------------------------------------------
//
////////////////////////////////////////////////////////////////////////////////


function _biz_portal_get_user_ip()
{
    $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['X_FORWARDED_FOR'])) {
        $X_FORWARDED_FOR = explode(',', $_SERVER['X_FORWARDED_FOR']);
        if (!empty($X_FORWARDED_FOR)) {
            $REMOTE_ADDR = trim($X_FORWARDED_FOR[0]);
        }
    }
    /*
     * Some php environments will use the $_SERVER['HTTP_X_FORWARDED_FOR']
    * variable to capture visitor address information.
    */
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $HTTP_X_FORWARDED_FOR= explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        if (!empty($HTTP_X_FORWARDED_FOR)) {
            $REMOTE_ADDR = trim($HTTP_X_FORWARDED_FOR[0]);
        }
    }
    return preg_replace('/[^0-9a-f:\., ]/si', '', $REMOTE_ADDR);
}

/**
 * Return table name prefixed with wp default prefix
 *  
 * @param string $name
 * @return string
 */
function _biz_portal_get_table_name($name)
{
    $prefix = biz_portal_get_table_prefix();
    return $prefix . $name;
}

/**
 * Retrieve the email tempalte from database
 *
 * @param string $id
 * @return array ARRAY_A
 */
function _biz_portal_get_email_template($id)
{
    global $wpdb;
    $sql = "SELECT * FROM " . _biz_portal_get_table_name('email_templates') . " WHERE id = '%s'";
    $sql = sprintf($sql, $id);
    $res = $wpdb->get_row($sql);
    return $res;
}


function biz_portal_get_messages()
{
	?>
	<div class="row">
	<div class="col-md-12">
		    	<?php $success = BP_FlashMessage::Get(BP_FlashMessage::SUCCESS) ?>
		    	<?php if (count($success) > 0) : ?>
			        <div class="alert alert-success alert-dismissable">
			            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
			            <?php foreach ($success as $message) : ?>
			            	<?php echo $message ?><br />
			        	<?php endforeach; ?>
			        </div>
		    	<?php endif; ?>
		    	<?php $success = BP_FlashMessage::Get(BP_FlashMessage::INFO) ?>
		    	<?php if (count($success) > 0) : ?>
			        <div class="alert alert-info alert-dismissable">
			            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
			            <?php foreach ($success as $message) : ?>
			            	<?php echo $message ?><br />
			        	<?php endforeach; ?>
			        </div>
		    	<?php endif; ?>
		    	<?php $success = BP_FlashMessage::Get(BP_FlashMessage::ERROR) ?>
		    	<?php if (count($success) > 0) : ?>
			        <div class="alert alert-danger alert-dismissable">
			            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
			            <?php foreach ($success as $message) : ?>
			            	<?php echo $message ?><br />
			        	<?php endforeach; ?>
			        </div>
		    	<?php endif; ?>
		    </div>
		</div>
		<?php 
}

function biz_portal_get_directory_list(ViewModel_Companies $vm_companies)
{
    $html = '';
    $last_alpha = '';
    foreach ($vm_companies->companies as $company)
    {
        $contact_key = array_shift(array_keys($company->contacts));
        $address_key = array_shift(array_keys($company->addresses));
        $region = '';
        $contact_person = '';
        $phone = '';
        $email = '';
        
        if(isset($company->addresses[$address_key])) {
            $region = $company->addresses[$address_key]->city . ', ' . 
                $company->addresses[$address_key]->region;
        }
        if (isset($company->contacts[$contact_key])) {
            $contact_person = $company->contacts[$contact_key]->contact_person;
            $phone = $company->contacts[$contact_key]->telephone;
            $email = $company->contacts[$contact_key]->email;
        }
        
        $industries = '';
        if (is_array($company->industries)) {
            foreach ($company->industries as $industry) {
                if (!empty($industries)) $industries .= ", ";
                $industries .= $industry->ind_name;
            }
        }
                
        $first_letter = strtoupper(substr($company->company_name, 0, 1));
        if (empty($last_alpha) || $first_letter != $last_alpha) {
            $last_alpha = $first_letter;
            $html .='<li class="caption">
    		<div class="col-md-12">
        			<span class="directory_letter_title">' . $last_alpha . '</span>
        			<hr style="float: left; width: 85%" />
        		</div>
        	</li>';
        }
        $html .= '<li class="details">';
        $html .= '
            <div class="row">
                <div class="col-md-12">
    				<span class="directory_company_title">' . $company->company_name . '</span>
    				<div class="title_divider"></div>
    			</div>
            </div>
    		<div class="row text-small">    			
    			<div class="col-md-12">
    			    <div class="row">
    			        <div class="col-md-4 col-sm-6 row-label"><i class=""></i> Product Category:</div>
    			        <div class="col-md-8 col-sm-6 row-value">' . $industries . '</div>
    			    </div>
    			    <div class="row">
    			        <div class="col-md-4 col-sm-6 row-label"><i class=""></i> Sales Region:</div>
    			        <div class="col-md-8 col-sm-6 row-value">' . $region . '</div>
    			    </div>
    			    <div class="row">
    			        <div class="col-md-4 col-sm-6 row-label"><i class=""></i> Contact Person:</div>
    			        <div class="col-md-8 col-sm-6 row-value">' . $contact_person . '</div>
    			    </div>
    			    <!--
    			    <div class="row">
    			        <div class="col-md-4 col-sm-6 row-label"><i class=""></i> Email:</div>
    			        <div class="col-md-8 col-sm-6 row-value">' . '' . '</div>
    			    </div> -->
    			    <div class="row">
    			        <div class="col-md-4 col-sm-6 row-label"><i class=""></i> Phone:</div>
    			        <div class="col-md-8 col-sm-6 row-value">' . $phone . '</div>
    			    </div>
    			</div>    
    		</div>';
        $html .= '</li>';
    }
    
    if ($vm_companies->total > (($vm_companies->offset + $vm_companies->count)))
    {
        $html .= '<li class="tools"><span class="hidden loading pull-left"><img src="' . get_template_directory_uri() . '/images/loading.gif" /></span><input type="button" name="btn_load_more" class="btn pull-right btn_load_more" value="Load More .."></button></li>';
    }
    return $html;
}

























//
