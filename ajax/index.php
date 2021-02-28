<?php
header('Content-Type: application/json');
define('WP_USE_THEMES', true);
/** Loads the WordPress Environment and Template */
if ( !isset($wp_did_header) ) {

	$wp_did_header = true;
	require_once( dirname(__FILE__) . '/../wp-load.php' );	
}

require_once __DIR__ . '/support.php';

//print_r(biz_poratal_get_biz_services_list());

//print_r(biz_portal_get_company_by_email('luwis@gmail.com'));

class BP_AjaxMode
{
	const CHECK_COMPANY = 'CHECK_COMPANY';
	const SIGNUP_FORM_SUBMIT = 'SIGNUP_FORM_SUBMIT';	
	const ADD_FAVOURITE = 'ADD_FAVOURITE';
	const CHECK_FAVOURITE = 'CHECK_FAVOURITE';
	const REMOVE_FAVOURITE = 'REMOVE_FAVOURITE';
	const SEND_MESSAGE = 'SEND_MESSAGE';
	const MESSAGE_MARK_READ = 'MESSAGE_MARK_READ';
	const NODES_LIST = 'NODES_LIST';
	const UPDATE_OPTION = 'UPDATE_OPTION';
	const GET_COMPANY = 'GET_COMPANY';
	const GET_DIRECTORY = 'GET_DIRECTORY';
	const FIND_COMPANY_BY_EMAIL = 'FIND_COMPANY_BY_EMAIL';
}

$mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
$result = array('mode' => $mode, 'done' => false, 'result' => array());

ob_start();

if ($mode === BP_AjaxMode::CHECK_COMPANY) {
	$reg_no = filter_input(INPUT_POST, 'reg_no', FILTER_SANITIZE_STRING);
	$country_id = filter_input(INPUT_POST, 'country_id', FILTER_VALIDATE_INT);

	if ($reg_no && $country_id) { 
		
		$com_view_model = biz_portal_search_companies(
			array('reg_number' => $reg_no, 'country_of_incorporate' => $country_id), 
			array('%s', '%d'));
		if ($com_view_model['total'] == 0) {
			$result['result']['company_exists'] = false;
		}
		else
		{
			$result['result']['company_exists'] = true;
		}
	}
}
else if ($mode === BP_AjaxMode::SIGNUP_FORM_SUBMIT)
{
	$post_data = $_POST;
	
	if ($_POST['member_type'] === BP_MemberType::TYPE_INTL)
		$member_type = BP_MemberType::TYPE_INTL;
	else if ($_POST['member_type'] === BP_MemberType::TYPE_SME)
		$member_type = BP_MemberType::TYPE_SME;
	else if ($_POST['member_type'] == BP_MemberType::TYPE_NGO)
	    $member_type = BP_MemberType::TYPE_NGO;
	
	$contact_email = filter_var($post_data['contact_email'], FILTER_VALIDATE_EMAIL);
	$terms_accepted = filter_var($post_data['terms_accepted'], FILTER_VALIDATE_INT);
	$id = filter_var($post_data['id'], FILTER_VALIDATE_INT);
		
	$nonce_verified = false;
	if ( isset( $_POST['signup_verf'] )
			&& wp_verify_nonce( $_POST['signup_verf'], 'portal_signup' ) ) 
	{
		$nonce_verified = true;		
	}
	
	if (!$nonce_verified)
	{
		$result['validation_errors'] = array('signup_verf' => 'Verification failed');
	}
	else if (!$terms_accepted)
	{
	    $result['validation_errors'] = array('terms_accepted' => 'Please accept the terms to proceed.');
	}
	else if (!$contact_email)
	{
		$result['validation_errors'] = array('contact_email' => 'Contact email is not valid');
	}
	else {
		$company_found = biz_portal_get_company_by_email($contact_email);
		$company_by_id = null;
		if ($id > 0) {
		    $company_by_id = biz_portal_get_company($id);
		}
		
		if (!$member_type) {
		    $result['validation_errors_count'] = 1;
		    $result['validation_errors'] = array('member_type' => 'Member Type not set.');
		}
		else if ($id > 0 && !$company_by_id) {
		    $result['validation_errors_count'] = 1;
		    $result['validation_errors'] = array('id' => 'There is no company by specified id');
		}
		else if ($company_found && $id > 0 && $company_by_id->id != $company_found->id) {
		    $result['validation_errors_count'] = 1;
		    $result['validation_errors'] = array('contact_email' => 'Contact email mismatch the selected company');
		}
		else if ($company_found && !$id > 0) {
		    $result['validation_errors_count'] = 1;
		    $result['validation_errors'] = array('contact_email' => 'You have already one company registered with this email ID');
		}
		else
		{
			if ($member_type === BP_MemberType::TYPE_INTL)
				$signup_internationl = new bp\signup\International(0);
			else if($member_type == BP_MemberType::TYPE_NGO)
			    $signup_internationl = new bp\signup\NGO(0);
			else
				$signup_internationl = new bp\signup\Local(0);
	
			$validators = $signup_internationl->get_validators();
			
			if ($company_by_id)
			    $company = $company_by_id;
			else
			    $company = new BP_Company();
			
			if ($company->id == 1)
			    die('you can not update this company.');
			
			$post_values = filter_var_array($post_data, $validators);
			$company = $signup_internationl->execute_post($company, $post_values);
			$errors = $signup_internationl->get_validation_errors();
			$result['success'] = false;
			if (count($errors) == 0) {
				//var_dump($company->biz_give_investment);
				try
				{
					$insert = biz_portal_update_company($company);
					$result['done'] = true;
					$result['validation_errors_count'] = 0;
					if ($insert) {
						$result['success'] = true;
						if (!EMAIL_DISABLED)
						    biz_portal_trigger_company_create($company);
						
						// Save additional values
						$additional_values = profile_additional_validate($_POST);
						profile_save($wpdb, $company->id, $additional_values);
						attachment_save($wpdb, $company->id, $additional_values);
					}
				}
				catch (Exception $ex)
				{
					$errors = array('ex' => $ex->getMessage());
					$result['validation_errors_count'] = count($errors) + 1;
					$result['validation_errors'] = $errors;
				}
			}
			else {
				$result['validation_errors_count'] = count($errors);
				$result['validation_errors'] = $errors;
			}
		}
	}
}

else if ($mode === BP_AjaxMode::CHECK_FAVOURITE)
{
    $s_company_id = filter_input(INPUT_POST, 's_cid', FILTER_VALIDATE_INT);
    $t_company_id = filter_input(INPUT_POST, 't_cid', FILTER_VALIDATE_INT);
    
    if (is_null($t_company_id) || is_null($s_company_id))
    {
        //
    }
    else {
        $repo_fav = new BP_Repo_Favourites($wpdb, biz_portal_get_table_prefix());
        $res = $repo_fav->is_favourited($s_company_id, $t_company_id);
        $result['done'] = true;
        $result['found'] = $res;
    }
}

else if ($mode === BP_AjaxMode::ADD_FAVOURITE)
{
    $s_company_id = filter_input(INPUT_POST, 's_cid', FILTER_VALIDATE_INT);
    $t_company_id = filter_input(INPUT_POST, 't_cid', FILTER_VALIDATE_INT);
    
    if (is_null($t_company_id) || is_null($s_company_id))
    {
        //
    }
    else {
        $repo_fav = new BP_Repo_Favourites($wpdb, biz_portal_get_table_prefix());
        $res = $repo_fav->add_favourite($s_company_id, $t_company_id);
        $result['done'] = true;
        $result['success'] = $res;
    }
}

else if ($mode === BP_AjaxMode::REMOVE_FAVOURITE)
{
    $s_company_id = filter_input(INPUT_POST, 's_cid', FILTER_VALIDATE_INT);
    $t_company_id = filter_input(INPUT_POST, 't_cid', FILTER_VALIDATE_INT);
    
    if (is_null($t_company_id) || is_null($s_company_id))
    {
        //
    }
    else {
        $repo_fav = new BP_Repo_Favourites($wpdb, biz_portal_get_table_prefix());
        $res = $repo_fav->remove_favourite($s_company_id, $t_company_id);
        $result['done'] = true;
        $result['success'] = $res;
    }
}

else if ($mode === BP_AjaxMode::SEND_MESSAGE)
{
    $s_company_id = filter_input(INPUT_POST, 's_cid', FILTER_VALIDATE_INT);
    $t_company_id = filter_input(INPUT_POST, 't_cid', FILTER_VALIDATE_INT);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $reply_to = filter_input(INPUT_POST, 'reply_to', FILTER_VALIDATE_INT);
    if (is_null($t_company_id)  || empty($message))
    {
        //
    }
    else if ($s_company_id == $t_company_id) 
    {
        // you can not message yourselves
    }
    else {        
        $res = biz_portal_pm_send($t_company_id, $message);        
        if ($res === true) {
            $result['done'] = true;
            $result['success'] = true;
        }
        else {
            $result['done'] = true;
            $result['success'] = false;
        }
    }
}

else if ($mode === BP_AjaxMode::MESSAGE_MARK_READ)
{
    $message_id = filter_input(INPUT_POST, 'message_id', FILTER_VALIDATE_INT);
    $message = biz_portal_pm_find_by_id($message_id);

    if (!$message) {
        $result['done'] = true;
        $result['success'] = true;
    }
    else if ($message->owner_id != biz_portal_get_current_company_id())
    {
        $result['done'] = true;
        $result['success'] = false;
        $result['message'] = 'This message not belongs to you';
    }
    else if ($message) {
        $res = biz_portal_pm_mark_read($message_id);
        $result['done'] = true;
        if ($res > 0) {
            $result['success'] = true;
        }
        else 
            $result['success'] = false;
    }
}

else if ($mode === BP_AjaxMode::NODES_LIST)
{
    global $wpdb;
    $repo_node = new BP_Repo_Nodes($wpdb, biz_portal_get_table_prefix());
    
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $option_id = filter_input(INPUT_POST, 'option_id', FILTER_VALIDATE_INT);
    $cat = filter_input(INPUT_POST, 'cat', FILTER_VALIDATE_INT);
    $company_id = filter_input(INPUT_POST, 'company_id', FILTER_VALIDATE_INT);
    
    $nodes = array();
    if ($option_id > 0) {
        $nodes = $repo_node->find_nodes_included($type, array('company_id' => $company_id), $option_id, 20);
    }
    else {
        $vm_nodes = biz_portal_node_get_list($type, 0, '', '' , $company_id , 20);
        $nodes = $vm_nodes->nodes;
    }
    
    $html = '<ul class="feeds">';
    foreach ($nodes as $node) {
        $html .= '<li id="list_' . $node->id . '">
			<div class="col-md-12">
            	<em>' . date('d M Y', strtotime($node->created)) . '</em><br>	
                <span class="list_title">' . $node->title . '</span>
                <p style="line-height:normal">' . esc_attr($node->body) . '<br />';
        foreach ($node->attachments as $file) {
            if ($file->id > 0) {
                $url = '';
                $link_text = 'Download';
                if ($file->is_image) {
                    $link_text = 'View';
                    $url = biz_portal_get_file_url($file->id);
                }
                else {
                    $url = biz_portal_get_file_url($file->id, 0, 1);
                }
                $html .= '<a href="' . $url . '" target="_blank"><i class="fa fa-cloud-download"></i> ' . $link_text . '</a> ';
            }
        }        
        $html .= '</p>
			</div>';
    }
    $html .= '</ul>';
    
    $result['done'] = true;
    $result['success'] = true;
    $result['html'] = $html;
}

else if ($mode === BP_AjaxMode::UPDATE_OPTION) 
{
    $data_id = filter_input(INPUT_POST, 'data_id', FILTER_SANITIZE_STRING);
    //$data_value = filter_input(INPUT_POST, 'data_value', FILTER_SANITIZE_STRING);
    
    $data_value = trim($_POST['data_value']);
    //$data_value = htmlspecialchars(trim($_POST['data_value']));
    
    $has_permission = current_user_can('edit_post');
    
    if (!is_null($data_value)) {
        $data_value = trim(nl2br($data_value));
    }
    
    if (!is_null($data_id) && !is_null($data_value) && $has_permission) {
        $res = update_option($data_id, $data_value);        
        $result['done'] = true;
        $result['success'] = $res;
        $result['value'] = get_option($data_id);
    }
    else if (!$has_permission) {
        $result['sucess'] = false;
        $result['message'] = 'You do not have permission to do this';
    }
}

else if ($mode === BP_AjaxMode::GET_COMPANY)
{
    $company_id = filter_input(INPUT_POST, 'company_id', FILTER_VALIDATE_INT);
    
    if ($company_id > 0) {
        $BP_Company = biz_portal_get_company($company_id);
        $BP_Company_Profile = biz_portal_get_company_profile($company_id);
        
        $result['success'] = true;
        $result['result']['company'] = $BP_Company;
        $result['result']['profile'] = $BP_Company_Profile;
    }
}

else if ($mode === BP_AjaxMode::GET_DIRECTORY)
{
    $filter_industries = filter_input(INPUT_POST, 'filter_industries', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
    $filter_alpha      = filter_input(INPUT_POST, 'filter_alpha', FILTER_SANITIZE_STRING);
    $filter_q          = filter_input(INPUT_POST, 'filter_q', FILTER_SANITIZE_STRING);
    $filter_dir        = filter_input(INPUT_POST, 'filter_dir', FILTER_SANITIZE_STRING,
            array('options' => array('default' => 'SME')));
    $filter_offset     = filter_input(INPUT_POST, 'filter_offset', FILTER_VALIDATE_INT, 
            array('options' => array('default' => 0)));
    $filter_count      = filter_input(INPUT_POST, 'filter_count', FILTER_VALIDATE_INT, 
            array('options' => array('default' => 10)));
    if (!is_null($filter_alpha)) $filter_alpha = esc_sql($filter_alpha);
    if (!is_null($filter_q)) $filter_q = esc_sql($filter_q);
    
    $filter = new BP_Directory_Filter();
    $filter->alphabet = $filter_alpha;
    $filter->industries = $filter_industries;
    $filter->search_term = $filter_q;
    
    switch($filter_dir)
    {
        case 'SME':
            $filter->member_type_id = BP_MemberType::TYPE_SME;
            break;
        case 'BIZ_PARTNER' :
            $filter->bool_biz_need_partner_in = true;
            break;
        case 'SERV_PRO' :
            $filter->bool_biz_give_service = true;
            break;
        case 'INVESTORS' :
            $filter->bool_biz_give_invest = true;
            break;
        case 'NGO' :
            $filter->member_type_id = BP_MemberType::TYPE_NGO;
            break;
    }
    
    $repo = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix());
    $vm_companies = $repo->filter_directory($filter, $filter_count, $filter_offset);
    $result['done'] = true;
    
    if ($vm_companies instanceof ViewModel_Companies) {
        $result['success'] = true;
        $result['html'] = biz_portal_get_directory_list($vm_companies);
        $result['count'] = $vm_companies->count;
        $result['offset'] = $vm_companies->offset;
        $result['total'] = $vm_companies->total;
    }
}
else if ($mode = BP_AjaxMode::FIND_COMPANY_BY_EMAIL)
{
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if ($email)
    {
        $result['done'] = true;
        //$company = biz_portal_get_company_by_email($email);
        $company = biz_portal_find_company_by_email_simple($email);
        if (isset($company->id)) {
            $result['success'] = true;
            $result['company_id'] = $company->id;
            $result['company_name'] = $company->company_name;
        }
        else {
            $result['success'] = true;
            $result['company_id'] = 0;
        }
    }
    else 
    {
        $result['done'] = false;
        $result['success'] = false;
        $result['message'] = 'Invalid email address';
        $result['company_id'] = 0;
    }
}

$ob_content = ob_get_clean();
@file_put_contents( __DIR__ . '/../error_log_ajax', $ob_content, FILE_APPEND);


echo json_encode($result);
