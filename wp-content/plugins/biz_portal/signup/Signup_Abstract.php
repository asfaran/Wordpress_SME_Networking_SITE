<?php
/**
 * Class signup abstract
 *
 * @author muneer
 */

namespace bp\signup;

abstract class Signup_Abstract
{
	protected $validation_error;
	protected $company;
	protected $company_summary_max = 360;
	protected $member_type;

	const VALIDATION_METHOD_FILTER_INPUT = 1;
	const VALIDATION_METHOD_FILTER_VAR = 2;

	protected function __construct($member_type)
	{
		$this->member_type = $member_type;
		$this->validation_error = array();
		$this->company = new \BP_Company();
	}
	
	/**
	 * Return validation errors in application data
	 * 
	 * @return array
	 */
	public function get_validation_errors()
	{
		return $this->validation_error;
	}

	/**
	 * Process the posted value from application form and returns an object of type BP_Company
	 * 
	 * @param \BP_Company $company
	 * @param array|mixed $post_values
	 * @return \BP_Company
	 */
	protected function execute_post($company, array $post_values)
	{
		// @var $company \BP_Company;
		//
		// Main company informations
		// =========================
		//
		$company->member_type_id = $this->member_type;
		$company->id = $post_values['id'];
		$company->company_name = $post_values['company_name'];
		$company->reg_number = $post_values['reg_number'];
		$company->country_of_incorporate = $post_values['country_of_incorporate'];
		$company->year_of_incorporate = $post_values['year_of_incorporate'];
		$company->location_head_office = $post_values['location_head_office'];
		$company->ceo_md = $post_values['ceo_md'];
		$company->other_branch = $post_values['other_branch'];

		$turnover = $post_values['turnover'];
		if ($turnover) {
			$turnover = explode(',', $turnover);
			$company->turnover_min = $turnover[0];
			$company->turnover_max = $turnover[1];
		}

		$num_employee = $post_values['num_employee'];
		if ($num_employee) {
			$num_employee = explode(',', $num_employee);
			$company->num_employee_min = $num_employee[0];
			$company->num_employee_max = $num_employee[1];
		}

		$company->summary = $post_values['summary'];
		//if (str_word_count($company->summary) > $this->company_summary_max) {
		if (strlen($company->summary) > $this->company_summary_max) {
			$this->validation_error[]
				= array('summary', 'Summary exceeds maximum limts of ' . $this->company_summary_max . ' characters.');
		}
		
		$company->terms_accepted = $post_values['terms_accepted'];
		
		$company->biz_need_details = array();
		
		//NGO
		$company->bool_biz_need_ngo_supp_serv = 0;
		$company->biz_need_ngo_supp_serv = null;
		//LOCAL
		$company->biz_need_services = array();
		$company->bool_biz_need_service = 0;
		// ""
		$company->bool_biz_need_invest = 0;
		$company->biz_need_investment = null;
		
		

		//
		// Contact informations
		// ====================
		//
		$contact = new \BP_Contact();
		$company->add_contact($contact);

		$contact->contact_person = $post_values['contact_person'];
		$contact->position = $post_values['contact_position'];
		$contact->telephone = $post_values['contact_telephone'];
		$contact->fax = $post_values['contact_fax'];
		$contact->web = $post_values['contact_web'];
		$contact->mobile = $post_values['contact_mobile'];
		$contact->email = $post_values['contact_email'];
		if (!$contact->email) {
			$this->validation_error[]
				= array('contact_email', 'Contact persons\'s email is not valid');
		}

		//
		// Address information
		// ===================
		//
		$address = new \BP_Address();
		$company->add_address($address);

		$address->company_number = $post_values['address_number'];
		/*if (!$address->company_number) {
			$this->validation_error[]
				= array('address_number', 'Mailing address 1 is incorrect.');
		}*/
		$address->city = $post_values['address_city'];
		$address->region = $post_values['address_region'];
		$address->street = $post_values['address_street'];
		$address->postal_code = $post_values['address_postal_code'];
		/*if (!$address->postal_code) {
			$this->validation_error[]
				= array('address_postal_code', 'Postel code is not in correct format.');
		}*/
		$address->country_id = $post_values['address_country'];

		//
		// Industries
		// ==========
		//
		if (isset($post_values['company_industries']) && is_array($post_values['company_industries'])) {
			foreach ($post_values['company_industries'] as $id) {
				if ($id) {
					$industry = new \BP_Industry($id);
					$company->add_industry($industry);
				}
			}
		}

		//
		// Type of business
		// ================
		//
		if (isset($post_values['company_biz_types']) && is_array($post_values['company_biz_types'])) {
			foreach ($post_values['company_biz_types'] as $id) {
				if ($id) {
					$biz_type = new \BP_BizType($id);
					$company->add_biz_type($biz_type);
				}
			}
		}
		$company_biz_types_other = $post_values['company_biz_types_other'];
		if ($company_biz_types_other) {
			$biz_type = new \BP_BizType();
			$biz_type->type_text = $company_biz_types_other;
			$biz_type->is_user_value = 1;
			$company->add_biz_type($biz_type);
		}

		//
		// Business needs
		// Partners in
		// ==============		
		$biz_need_partner = $post_values['biz_need_partner'];
		$company->bool_biz_need_partner_in = $biz_need_partner;
		if ($biz_need_partner) 
		{			
			$company->bool_biz_need_partner_in = $biz_need_partner;

			//
			// Business types
			//
			if (is_array($post_values['biz_needs_partner_in']))
			{		
				foreach ($post_values['biz_needs_partner_in'] as $id) {
					if (!$id) continue;
					$biz_type = new \BP_BizType($id);
					$company->biz_need_partner_biz_types[] = $biz_type;
				}				
			}
			$biz_needs_partner_other = $post_values['biz_needs_partner_other'];
			if ($biz_needs_partner_other) {
				$biz_type = new \BP_BizType();
				$biz_type->type_text = $biz_needs_partner_other;
				$biz_type->is_user_value = 1;
				$company->biz_need_partner_biz_types[] = $biz_type;
			}
		
			//
			// Industries
			// 
			if (is_array($post_values['biz_needs_partner_in_ind']))
			{
				foreach ($post_values['biz_needs_partner_in_ind'] as $id) {			
					if (!$id) continue;
					$industry = new \BP_Industry($id);
					$company->biz_need_partner_industries[] = $industry;
				}
			}
			$biz_needs_partner_in_ind_other = $post_values['biz_needs_partner_in_ind_other'];
			if ($biz_needs_partner_in_ind_other) {
				$industry = new \BP_Industry();
				$industry->ind_name = $biz_needs_partner_in_ind_other;
				$industry->is_user_value = 1;
				$company->biz_need_partner_industries[] = $industry;
			}
		}
		else {
		    $company->bool_biz_need_partner_in = 0;
		    $company->biz_need_partner_biz_types = array();
		    $company->biz_need_partner_industries = array();
		}
		
		
		
		//
		// Business give
		// Invest
		// ==============
		//
		$biz_give_invest = $post_values['biz_give_invest'];
		
		if ($biz_give_invest) {
		    $company->bool_biz_give_invest = $biz_give_invest;
		
		    $biz_give_invest_amount = $post_values['biz_give_invest_amount'];
		    $invest = new \BP_BizNeedInvestment();
		    if ($biz_give_invest_amount) {
		        $biz_give_invest_amount = explode(',', $biz_give_invest_amount);
		
		        $invest->min = $biz_give_invest_amount[0];
		        $invest->max = $biz_give_invest_amount[1];
		    }
		
		    $biz_give_invest_emp_size = $post_values['biz_give_invest_emp_size'];
		    if ($biz_give_invest_emp_size) {
		        $biz_give_invest_emp_size = explode(',', $biz_give_invest_emp_size);
		        $invest->sme_employee_min = $biz_give_invest_emp_size[0];
		        $invest->sme_employee_max = $biz_give_invest_emp_size[1];
		    }
		    	
		    // industry
		    if (is_array($post_values['biz_give_invest_ind'])) {
    		    foreach ($post_values['biz_give_invest_ind'] as $id) {
    		        if (!$id) continue;
    		        $industry = new \BP_Industry($id);
    		        $invest->add_industry($industry);
    		    }
		    }
		    $biz_give_invest_ind_other = $post_values['biz_give_invest_ind_other'];
		    if ($biz_give_invest_ind_other) {
		        $industry = new \BP_Industry();
		        $industry->ind_name = $biz_give_invest_ind_other;
		        $industry->is_user_value = 1;
		        $invest->add_industry($industry);
		    }
		    	
		    //Turnover
		    $biz_give_invest_turnover = $post_values['biz_give_invest_turnover'];
		    if ($biz_give_invest_turnover) {
		        $biz_give_invest_turnover = explode(',', $biz_give_invest_turnover);
		        $invest->turnover_min = $biz_give_invest_turnover[0];
		        $invest->turnover_max = $biz_give_invest_turnover[1];
		    }
		    $biz_give_invest_turnover_other = $post_values['biz_give_invest_turnover_other'];
		    if ($biz_give_invest_turnover_other) {
		        $invest->turnover_other = $biz_give_invest_turnover_other;
		    }
		    	
		    // Years in business
		    $biz_give_invest_yrs = $post_values['biz_give_invest_yrs'];
		    if ($biz_give_invest_yrs) {
		        $biz_give_invest_yrs = explode(',', $biz_give_invest_yrs);
		        $invest->years_in_biz_min = $biz_give_invest_yrs[0];
		        $invest->years_in_biz_max = $biz_give_invest_yrs[1];
		    }
		    $biz_give_invest_yrs_other = $post_values['biz_give_invest_yrs_other'];
		    if ($biz_give_invest_yrs_other) {
		        $invest->years_in_biz_other = $biz_give_invest_yrs_other;
		    }
		
		    $invest->invest_type = \BP_BizNeedInvestment::TYPE_PROVIDE;
		    $company->biz_give_investment = $invest;
		}
		else {
		    $company->bool_biz_give_invest = 0;
		    $company->biz_give_investment = null;
		}
		
		
		// Business needs
		// Looking for Provide Service / Service Provider
		// ==============================================
		//
		$biz_give_service_provide_bool = $post_values['biz_give_service_provide_bool'];
		if ($biz_give_service_provide_bool)
		{
		    $biz_give_services = array();
		    if (is_array($post_values['biz_give_service_provide']))
		    {
		        foreach ($post_values['biz_give_service_provide'] as $id)
		        {
		            if (!$id) continue;
		            $biz_service = new \BP_BizService($id);
		            $biz_give_services[] = $biz_service;
		            //$company->add_biz_need_service($biz_service);
		        }
		    }
		    $biz_give_service_provide_other = $post_values['biz_give_service_provide_other'];
		    if ($biz_give_service_provide_other) {
		        $biz_service = new \BP_BizService();
		        $biz_service->service_name = $biz_give_service_provide_other;
		        $biz_service->is_user_value = 1;
		        $biz_give_services[] = $biz_service;
		        //$company->add_biz_need_service($biz_service);
		    }
		    
		    $company->biz_give_services = $biz_give_services;
		    $company->bool_biz_give_service = 1;
		}
		else {
		    $company->biz_give_service = array();
		    $company->bool_biz_give_service = 0;
		}


		//
		// Business need Detail
		//======================
		//

		// biz_give_detail_sp
		if ($biz_give_service_provide_bool && isset($post_values['biz_give_detail_sp']))
		{
		    $BP_BizNeedDetail = new \BP_BizNeedDetail();
		    $BP_BizNeedDetail->company_id = $company->id;
		    $BP_BizNeedDetail->detail = $post_values['biz_give_detail_sp'];
		    $BP_BizNeedDetail->biz_need_type_id = \BP_BizNeedType::PROVIDE_SERVICE;
		
		    $company->biz_need_details[] = $BP_BizNeedDetail;
		    
		    //error_log(print_r($BP_BizNeedDetail, true));
		}

		// biz_need_detail_partner
		if ($company->bool_biz_need_partner_in && isset($post_values['biz_need_detail_partner']))
		{
			$BP_BizNeedDetail = new \BP_BizNeedDetail();
			$BP_BizNeedDetail->company_id = $company->id;			
			$BP_BizNeedDetail->detail = $post_values['biz_need_detail_partner'];
			$BP_BizNeedDetail->biz_need_type_id = \BP_BizNeedType::PARTNER;

			$company->biz_need_details[] = $BP_BizNeedDetail;
		}

		// biz_give_detail_invest
		if ($post_values['biz_give_invest'] && isset($post_values['biz_give_detail_invest']))
		{
		    $BP_BizNeedDetail = new \BP_BizNeedDetail();
		    $BP_BizNeedDetail->company_id = $company->id;
		    $BP_BizNeedDetail->detail = $post_values['biz_give_detail_invest'];
		    $BP_BizNeedDetail->biz_need_type_id = \BP_BizNeedType::PROVIDE_INVEST;
		
		    $company->biz_need_details[] = $BP_BizNeedDetail;
		}


		
		//
		// Validation
		// ==========
		//
		if (empty($company->company_name))
			$this->validation_error[] = array('company_name', 'Please specify company name');
		if (empty($company->country_of_incorporate))
			$this->validation_error[] = array('country_of_incorporate', 'Please specify country of incorporation');
		//if (empty($company->year_of_incorporate))
		//	$this->validation_error[] = array('year_of_incorporate', 'Please specify year of incorporate');
		if (empty($company->location_head_office))
			$this->validation_error[] = array('location_head_office', 'Plaese specify location of head office');
		//if (empty($company->ceo_md))
		//	$this->validation_error[] = array('ceo_md', 'Please specify CEO/Managing Directory');
		/*if (empty($company->other_branch))
			$this->validation_error[] = array('other_branch', 'Please specify other branch');*/		
		
		
		return $company;
	}

	/**
	 * Callback for validating single dimensional checkboxes
	 * <input type="checkbox" name="chk[]" value="?" />
	 * <input type="checkbox" name="chk[]" value="?" />
	 * 	 
	 * @param array $args FITLERS & FLAGS
	 *
	 */
	public function validate_checkbox_1($args) {
	    return function ($data) use ($args) {
	    	return filter_var($data, $args['filter'], $args['flag']);
	    };
	}

	/**
	 * Default validators
	 *
	 * @return array
	 */
	public function get_validators()
	{
		return array(
			'id'					=> FILTER_VALIDATE_INT,
			'company_name' 			=> FILTER_SANITIZE_STRING,
			'reg_number'			=> FILTER_SANITIZE_STRING,
			'country_of_incorporate'=> FILTER_VALIDATE_INT,
			'year_of_incorporate' 	=> FILTER_SANITIZE_NUMBER_INT,
			'location_head_office' 	=> FILTER_SANITIZE_STRING,
			'ceo_md' 			=> FILTER_SANITIZE_STRING,
			'other_branch' 		=> FILTER_SANITIZE_STRING,
			'turnover' 			=> FILTER_SANITIZE_STRING,
			'num_employee' 		=> FILTER_SANITIZE_STRING,
			'summary'			=> FILTER_SANITIZE_STRING,
		    'terms_accepted'    => FILTER_VALIDATE_INT,
			'contact_person'	=> FILTER_SANITIZE_STRING,
			'contact_position'	=> FILTER_SANITIZE_STRING,
			'contact_telephone'	=> FILTER_SANITIZE_STRING,
			'contact_fax'		=> FILTER_SANITIZE_STRING,
			'contact_web'		=> FILTER_SANITIZE_STRING,
			'contact_mobile'	=> FILTER_SANITIZE_STRING,
			'contact_email'		=> FILTER_VALIDATE_EMAIL,
			'address_number'	=> FILTER_SANITIZE_STRING,
			'address_city'		=> FILTER_SANITIZE_STRING,
			'address_region'	=> FILTER_SANITIZE_STRING,
			'address_street'	=> FILTER_SANITIZE_STRING,
			'address_postal_code'	=> FILTER_VALIDATE_INT,
			'address_country'	=> FILTER_VALIDATE_INT,
			'company_industries'	=> array('filter' => FILTER_CALLBACK,
		        'options' => $this->validate_checkbox_1(array(
		            'filter' => FILTER_VALIDATE_INT,
		            'flag' => FILTER_REQUIRE_SCALAR,
		        ))),
			'company_biz_types'	=> array('filter' => FILTER_CALLBACK,
		        'options' => $this->validate_checkbox_1(array(
		            'filter' => FILTER_VALIDATE_INT,
		            'flag' => FILTER_REQUIRE_SCALAR,
		        ))),
			'company_biz_types_other' 	=> FILTER_SANITIZE_STRING,
			'biz_need_partner'			=> FILTER_VALIDATE_INT,
			'biz_needs_partner_in' 		=> array('filter' => FILTER_CALLBACK,
		        'options' => $this->validate_checkbox_1(array(
		            'filter' => FILTER_VALIDATE_INT,
		            'flag' => FILTER_REQUIRE_SCALAR,
		        ))),
			'biz_needs_partner_other'	=> FILTER_SANITIZE_STRING,
			'biz_needs_partner_in_ind' 	=> array('filter' => FILTER_CALLBACK,
		        'options' => $this->validate_checkbox_1(array(
		            'filter' => FILTER_VALIDATE_INT,
		            'flag' => FILTER_REQUIRE_SCALAR,
		        ))),
			'biz_needs_partner_in_ind_other'	=> FILTER_SANITIZE_STRING,
			'biz_give_invest'			=> FILTER_VALIDATE_INT,
			'biz_give_invest_amount'	=> FILTER_SANITIZE_STRING,
			'biz_give_invest_emp_size'	=> FILTER_SANITIZE_STRING,
			'biz_give_invest_ind' => array('filter' => FILTER_CALLBACK,
		        'options' => $this->validate_checkbox_1(array(
		            'filter' => FILTER_VALIDATE_INT,
		            'flag' => FILTER_REQUIRE_SCALAR,
		        ))),
			'biz_give_invest_ind_other'	=> FILTER_SANITIZE_STRING,
			'biz_give_invest_turnover'	=> FILTER_SANITIZE_STRING,
			'biz_give_invest_turnover_other'	=> FILTER_VALIDATE_INT,
			'biz_give_invest_yrs'		=> FILTER_SANITIZE_STRING,
			'biz_give_invest_yrs_other'	=> FILTER_VALIDATE_INT,
			'biz_give_service_provide_bool'	=> FILTER_VALIDATE_INT,
			'biz_give_service_provide' => array('filter' => FILTER_CALLBACK,
		        'options' => $this->validate_checkbox_1(array(
		            'filter' => FILTER_VALIDATE_INT,
		            'flag' => FILTER_REQUIRE_SCALAR,
		        ))),
			'biz_give_service_provide_other'	=> FILTER_SANITIZE_STRING,		
			'biz_need_detail_partner'	=> FILTER_SANITIZE_STRING,
			'biz_give_detail_invest'	=> FILTER_SANITIZE_STRING,
			'biz_give_detail_sp'		=> FILTER_SANITIZE_STRING,	
		);
	}
}