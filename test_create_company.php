<?php

header('Content-Type: application/json');
define('WP_USE_THEMES', true);
/** Loads the WordPress Environment and Template */
if ( !isset($wp_did_header) ) {

	$wp_did_header = true;
	require_once( dirname(__FILE__) . '/wp-load.php' );	
}

//print_r(biz_poratal_get_biz_services_list());

//print_r(biz_portal_get_company_by_email('luwis@gmail.com'));

class BP_AjaxMode
{
	const CHECK_COMPANY = 'CHECK_COMPANY';
	const SIGNUP_FORM_SUBMIT = 'SIGNUP_FORM_SUBMIT';
	const TEST_DATA = 'TEST_DATA';
}

$mode = filter_input(INPUT_GET, 'mode', FILTER_SANITIZE_STRING);
$result = array('result' => array());

	$names = array('Super', 'Glod', 'Fast', 'Well', 'Dine', 'Day', 'Daily', 'Craft', 'City', 'Mart', 'Market', 'Business', 'Rock', 'Solid', 'Cine');
	$name_ext = array('Company', 'Inc.', 'Trading Company', 'Corporation', 'Distributors', 'Manufactures', 'Co. Ltd.');
	$hnames = array('John', 'Rams', 'Luwis', 'Wills', 'Dine', 'Mario', 'Bob', 'Martin', 'Gayl', 'Marvan', 'Dasun', 'Amila', 'Don', 'Saba', 'Rony');

	$company_name = $names[rand(0, (count($names)-1))] . ' ' . $names[rand(0, (count($names)-1))];
	$contact_name = $hnames[rand(0, (count($hnames)-1))] . ' ' . $hnames[rand(0, (count($hnames)-1))];
	$ceo_name = $hnames[rand(0, (count($hnames)-1))] . ' ' . $hnames[rand(0, (count($hnames)-1))];

	/*$post_data = array(
			'id'					=> 0,
			'signup_verf'			=> '2342423424',
			'company_name' 			=> $company_name . ' ' . $name_ext[rand(0, (count($name_ext)-1))],
			'reg_number'			=> rand(111,999) . "-21jO-MDU-TDXB",
			'country_of_incorporate'=> 149,
			'year_of_incorporate' 	=> rand(1950, 2010),
			'location_head_office' 	=> "Dubai",
			'ceo_md' 			=> $ceo_name,
			'other_branch' 		=> "",
			'turnover' 			=> "0,1000000",
			'num_employee' 		=> "1001,200",
			'summary'			=> "This is a fast growing company based on Dubai.",
			'contact_person'	=> $contact_name,
			'contact_position'	=> "Marketing Manager",
			'contact_telephone'	=> "066634343",
			'contact_fax'		=> "066734343",
			'contact_web'		=> "http://wwww.noweb.it",
			'contact_mobile'	=> "0773434343",
			'contact_email'		=> strtolower(str_replace(' ', '_', $company_name)) . "@sb-ps.ae",
			'address_number'	=> "4545",
			'address_city'		=> "Dubai",
			'address_region'	=> "DXB Airport Region",
			'address_street'	=> "ManAvenue Road, <script>",
			'address_postal_code'	=> "111580",
			'address_country'	=> "66",
			'company_industries'	=> array(0=>2,1=>3),
			'company_biz_types'	=> array(0=>2,1=>3,2=>4,3=>"df3"),
			'biz_need_partner'			=> "1",
			'biz_needs_partner_in' 		=> array(0=>1,1=>2,2=>3),
			'biz_needs_partner_other'	=> "",
			'biz_needs_partner_in_ind' 	=> array(0=>3,1=>5,2=>6,3=>10),
			'biz_need_invest'			=> "1",
			'biz_need_invest_amount'	=> "1000001,2000000",
			'biz_need_invest_emp_size'	=> "0,50",
			'biz_need_invest_ind' => array(0=>2,1=>3,2=>10),
			'biz_need_invest_ind_other'	=> "Airlines",
			'biz_need_invest_turnover'	=> "0,1000000",
			'biz_need_invest_turnover_other'	=> "",
			'biz_need_invest_yrs'		=> "5,10",
			'biz_needs_service_provide_bool'	=> "1",
			'biz_needs_service_provide' => array(0=>2,1=>3),
			'biz_needs_service_provide_other'	=> "",	
			'biz_need_detail_partner' 	=> 'i want partner for me',
			'biz_need_detail_invest'    => 'i want invest',
			'biz_need_detail_sp'		=> 'I want service provider',
		);


	$member_type = BP_MemberType::TYPE_SME;*/
	
	$post_data = array(
	        'id'					=> 0,
	        'signup_verf'			=> '2342423424',
	        'company_name' 			=> $company_name . ' ' . $name_ext[rand(0, (count($name_ext)-1))],
	        'reg_number'			=> rand(111,999) . "-21jO-MDU-TDXB",
	        'country_of_incorporate'=> rand(1,100),
	        'year_of_incorporate' 	=> rand(1950, 2010),
	        'location_head_office' 	=> "Dubai",
	        'ceo_md' 			=> $ceo_name,
	        'other_branch' 		=> "",
	        'turnover' 			=> "0,1000000",
	        'num_employee' 		=> "1001,200",
	        'summary'			=> "This is a fast growing company based on Dubai.",
	        'contact_person'	=> $contact_name,
	        'contact_position'	=> "Marketing Manager",
	        'contact_telephone'	=> "066634343",
	        'contact_fax'		=> "066734343",
	        'contact_web'		=> "http://wwww.noweb.it",
	        'contact_mobile'	=> "0773434343",
	        'contact_email'		=> strtolower(str_replace(' ', '_', $company_name)) . "@s-b-p----s.ae",
	        'address_number'	=> "4545",
	        'address_city'		=> "Dubai",
	        'address_region'	=> "DXB Airport Region",
	        'address_street'	=> "ManAvenue Road, <script>",
	        'address_postal_code'	=> "111580",
	        'address_country'	=> "66",
	        'company_industries'	=> array(0=>2,1=>3),
	        'company_biz_types'	=> array(0=>2,1=>3,2=>4,3=>"df3"),
	        'biz_need_partner'			=> "1",
	        'biz_needs_partner_in' 		=> array(0=>1,1=>2,2=>3),
	        'biz_needs_partner_other'	=> "",
	        'biz_needs_partner_in_ind' 	=> array(0=>3,1=>5,2=>6,3=>10),
	        'biz_give_invest'			=> "1",
	        'biz_give_invest_amount'	=> "1000001,2000000",
	        'biz_give_invest_emp_size'	=> "0,50",
	        'biz_give_invest_ind' => array(0=>2,1=>3,2=>10),
	        'biz_give_invest_turnover'	=> "0,1000000",
	        'biz_give_invest_yrs'		=> "5,10",
	        'biz_give_invest_ind_other' => 'Industrial 2',
	        'biz_give_service_provide_bool'	=> "1",
	        'biz_give_service_provide' => array(0=>2,1=>3),
	        'biz_give_service_provide_other'	=> "",
	        'biz_need_ngo_supp_serv'    => "1",
	        'biz_need_ngo_supp_serv_type_other' => 'Account NGO Other service',
	        'biz_need_detail_partner' 	=> 'i want  a partner',
	        'biz_give_detail_invest'    => 'i want to invest',
	        'biz_give_detail_sp'		=> 'I want to give service',
	        'biz_need_detail_ngo'       => 'NGO Support service given',
	);
	
	
	$member_type = BP_MemberType::TYPE_INTL;

	$contact_email = filter_var($post_data['contact_email'], FILTER_VALIDATE_EMAIL);

	//$nonce_verified = false;
    $nonce_verified = true;

	/*if ( isset( $post_data['signup_verf'] )
			&& wp_verify_nonce( $post_data['signup_verf'], 'portal_signup' ) ) 
	{
		$nonce_verified = true;		
	}*/
	
	if (!$nonce_verified)
	{
		$result['validation_errors'] = array('signup_verf' => 'Verification failed');
	}
	else if (!$contact_email)
	{
		$result['validation_errors'] = array('contact_email' => 'Contact email is not valid');
	}
	else {
		$coumpany_found = biz_portal_get_company_by_email($post_data['contact_email']);
		
		//var_dump($coumpany_found);
		//exit();

		if ($member_type && $contact_email && !$coumpany_found)
		{
			if ($member_type === BP_MemberType::TYPE_INTL)
				$signup_form = new bp\signup\International(0);
			else
				$signup_form = new bp\signup\Local(0);

			$validators = $signup_form->get_validators();
			$company = new BP_Company();
			$post_values = filter_var_array($post_data, $validators);
			$company = $signup_form->execute_post($company, $post_values);
			$errors = $signup_form->get_validation_errors();
			$result['success'] = false;
			if (count($errors) == 0) {
				var_dump($company);
				try
				{
					$insert = biz_portal_update_company($company);
					$result['validation_errors_count'] = 0;
					if ($insert) {
						$result['success'] = true;
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
		else {
			$result['validation_errors_count'] = 1;
			if ($coumpany_found)
				$result['validation_errors'] = array('contact_email' => 'You have already one company registered with this email ID');	
			if (!$member_type)
				$result['validation_errors'] = array('member_type' => 'Member Type not set.');
		}
	}

	echo json_encode($result);