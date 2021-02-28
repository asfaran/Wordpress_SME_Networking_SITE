<?php
/**
 * class for signup local
 *
 * @author muneer
 */
namespace bp\signup;

class Local extends Signup_Abstract
{
	/**
	 * Class constructor
	 *
	 * @param int $uid
	 * @param int $member_type
	 */
	public function __construct($uid)
	{
		$member_type = \BP_MemberType::TYPE_SME;
		parent::__construct($member_type);
		$this->company->user_id = $uid;
		$this->company->member_type_id = $member_type;
	}
	
	/**
	 * Process the posted value from application form and returns an object of type BP_Company
	 *
	 * @param \BP_Company $company
	 * @param array|mixed $post_values
	 * @return \BP_Company
	 * @see bp\signup.Signup_Abstract::execute_post()
	 */
	public function execute_post($company, array $post_values)
	{
		// Execute parent
		$company = parent::execute_post($company, $post_values);
		
		//
		// Business need
		// invest
		// ==============
		//
		$biz_need_invest = $post_values['biz_need_invest'];
		
		if ($biz_need_invest) {
		    $company->bool_biz_need_invest = $biz_need_invest;
		
		    $biz_need_invest_amount = $post_values['biz_need_invest_amount'];
		    $invest = new \BP_BizNeedInvestment();
		    if ($biz_need_invest_amount) {
		        $biz_need_invest_amount = explode(',', $biz_need_invest_amount);
		
		        $invest->min = $biz_need_invest_amount[0];
		        $invest->max = $biz_need_invest_amount[1];
		    }
		
		    $biz_need_invest_emp_size = $post_values['biz_need_invest_emp_size'];
		    if ($biz_need_invest_emp_size) {
		        $biz_need_invest_emp_size = explode(',', $biz_need_invest_emp_size);
		        $invest->sme_employee_min = $biz_need_invest_emp_size[0];
		        $invest->sme_employee_max = $biz_need_invest_emp_size[1];
		    }
		    	
		    // industry
		    if (is_array($post_values['biz_need_invest_ind'])) {
    		    foreach ($post_values['biz_need_invest_ind'] as $id) {
    		        if (!$id) continue;
    		        $industry = new \BP_Industry($id);
    		        $invest->add_industry($industry);
    		    }
		    }
		    $biz_need_invest_ind_other = $post_values['biz_need_invest_ind_other'];
		    if ($biz_need_invest_ind_other) {
		        $industry = new \BP_Industry();
		        $industry->ind_name = $biz_need_invest_ind_other;
		        $industry->is_user_value = 1;
		    }
		    	
		    //Turnover
		    $biz_need_invest_turnover = $post_values['biz_need_invest_turnover'];
		    if ($biz_need_invest_turnover) {
		        $biz_need_invest_turnover = explode(',', $biz_need_invest_turnover);
		        $invest->turnover_min = $biz_need_invest_turnover[0];
		        $invest->turnover_max = $biz_need_invest_turnover[1];
		    }
		    $biz_need_invest_turnover_other = $post_values['biz_need_invest_turnover_other'];
		    if ($biz_need_invest_turnover_other) {
		        $invest->turnover_other = $biz_need_invest_turnover_other;
		    }
		    	
		    // Years in business
		    $biz_need_invest_yrs = $post_values['biz_need_invest_yrs'];
		    if ($biz_need_invest_yrs) {
		        $biz_need_invest_yrs = explode(',', $biz_need_invest_yrs);
		        $invest->years_in_biz_min = $biz_need_invest_yrs[0];
		        $invest->years_in_biz_max = $biz_need_invest_yrs[1];
		    }
		    $biz_need_invest_yrs_other = $post_values['biz_need_invest_yrs_other'];
		    if ($biz_need_invest_yrs_other) {
		        $invest->years_in_biz_other = $biz_need_invest_yrs_other;
		    }
		
		    $invest->invest_type = \BP_BizNeedInvestment::TYPE_NEED;
		    $company->biz_need_investment = $invest;
		}
		else {
		    $company->bool_biz_need_invest = 0;
		    $company->biz_need_investment = null;
		}
		
		//
		// Business needs
		// Provide Service / Service Provider
		// ==================================
		//
		$biz_needs_service_provide_bool = $post_values['biz_needs_service_provide_bool'];
		if ($biz_needs_service_provide_bool)
		{
		    $biz_need_services = array();
		    if (is_array($post_values['biz_needs_service_provide']))
		    {
		        foreach ($post_values['biz_needs_service_provide'] as $id)
		        {
		            if (!$id) continue;
		            $biz_service = new \BP_BizService($id);
		            $biz_need_services[] = $biz_service;
		            //$company->add_biz_need_service($biz_service);
		        }
		    }
		    $biz_needs_service_provide_other = $post_values['biz_needs_service_provide_other'];
		    if ($biz_needs_service_provide_other) {
		        $biz_service = new \BP_BizService();
		        $biz_service->service_name = $biz_needs_service_provide_other;
		        $biz_service->is_user_value = 1;
		        $biz_need_services[] = $biz_service;
		        //$company->add_biz_need_service($biz_service);
		    }
		
		    $company->biz_need_services = $biz_need_services;
		    $company->bool_biz_need_service = 1;
		}
		else {
		    $company->biz_need_services = null;
		    $company->bool_biz_need_service = 0;
		}
		
		
		//
		// Business need Detail
		//======================
		//
		// biz_need_detail_sp
		if ($biz_needs_service_provide_bool && isset($post_values['biz_need_detail_sp']))
		{
		    $BP_BizNeedDetail = new \BP_BizNeedDetail();
		    $BP_BizNeedDetail->company_id = $company->id;
		    $BP_BizNeedDetail->detail = $post_values['biz_need_detail_sp'];
		    $BP_BizNeedDetail->biz_need_type_id = \BP_BizNeedType::NEED_SERVICE;
		
		    $company->biz_need_details[] = $BP_BizNeedDetail;
		}
				
		// biz_need_detail_invest
		if ($post_values['biz_need_invest'] && isset($post_values['biz_need_detail_invest']))
		{
		    $BP_BizNeedDetail = new \BP_BizNeedDetail();
		    $BP_BizNeedDetail->company_id = $company->id;
		    $BP_BizNeedDetail->detail = $post_values['biz_need_detail_invest'];
		    $BP_BizNeedDetail->biz_need_type_id = \BP_BizNeedType::NEED_INVEST;
		
		    $company->biz_need_details[] = $BP_BizNeedDetail;
		}
		
		
		return $company;
	
	}
	
	/**
	 * Overriden function from super
	 * 
	 * @see bp\signup\Signup_Abstract::get_validators()
	 */
	public function get_validators()
	{
	    $validators_parent = parent::get_validators();
	    $validators = array(
	        'biz_need_invest'			=> FILTER_VALIDATE_INT,
			'biz_need_invest_amount'	=> FILTER_SANITIZE_STRING,
			'biz_need_invest_emp_size'	=> FILTER_SANITIZE_STRING,
			'biz_need_invest_ind' => array('filter' => FILTER_CALLBACK,
		        'options' => $this->validate_checkbox_1(array(
		            'filter' => FILTER_VALIDATE_INT,
		            'flag' => FILTER_REQUIRE_SCALAR,
		        ))),
			'biz_need_invest_ind_other'	=> FILTER_SANITIZE_STRING,
			'biz_need_invest_turnover'	=> FILTER_SANITIZE_STRING,
			'biz_need_invest_turnover_other'	=> FILTER_VALIDATE_INT,
			'biz_need_invest_yrs'		=> FILTER_SANITIZE_STRING,
			'biz_need_invest_yrs_other'	=> FILTER_VALIDATE_INT,
            'biz_needs_service_provide_bool'	=> FILTER_VALIDATE_INT,
            'biz_needs_service_provide' => array('filter' => FILTER_CALLBACK,
            'options' => $this->validate_checkbox_1(array(
                    'filter' => FILTER_VALIDATE_INT,
                    'flag' => FILTER_REQUIRE_SCALAR,
            ))),
            'biz_needs_service_provide_other'	=> FILTER_SANITIZE_STRING,
            'biz_need_detail_invest'	=> FILTER_SANITIZE_STRING,
            'biz_need_detail_sp'		=> FILTER_SANITIZE_STRING,
	    );
	
	    return array_merge($validators_parent, $validators);
	}
}