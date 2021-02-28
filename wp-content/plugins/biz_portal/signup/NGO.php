<?php
/**
 * class for signup international
 *
 * @author muneer
 *
 */
namespace bp\signup;

class NGO extends Signup_Abstract
{
	/**
	 * Class constructor
	 * 
	 * @param int $uid
	 * @param int $member_type
	 */
	public function __construct($uid)
	{
		$member_type = \BP_MemberType::TYPE_NGO;
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
		// Business needs
		// NGO Support service
		// ===================
		//
		$bool_biz_need_ngo_supp_serv = $post_values['biz_need_ngo_supp_serv'];
		if ($bool_biz_need_ngo_supp_serv) 
		{
			$company->bool_biz_need_ngo_supp_serv = 1;

			$biz_need_ngo_supp_serv = new \BP_BizNeedNGOSuppServ();
			$biz_need_ngo_supp_serv->org_type_development_agency 
				= $post_values['biz_need_ngo_supp_serv_org_type_1'];

			$biz_need_ngo_supp_serv->org_type_chamber_of_commerce 
				= $post_values['biz_need_ngo_supp_serv_org_type_2'];

			if (is_array($post_values['biz_need_ngo_supp_serv_type']))
			{
				foreach ($post_values['biz_need_ngo_supp_serv_type'] as $id) 
				{
					if (!$id) continue;
					$biz_service = new \BP_BizService($id);
					//$biz_need_services[] = $biz_service;
					$biz_need_ngo_supp_serv->add_services_provided($biz_service);
			    }
			}

			$serv_pro_other
				= $post_values['biz_need_ngo_supp_serv_type_other'];
			if (!empty($serv_pro_other)) {
			    $biz_service = new \BP_BizService();
			    $biz_service->is_user_value = 1;
			    $biz_service->service_name = $serv_pro_other;
			    //$biz_need_services[] = $biz_service;
			    $biz_need_ngo_supp_serv->add_services_provided($biz_service);
			}
			
			$biz_need_ngo_ss_fund = $post_values['biz_need_ngo_ss_fund'];
			if ($biz_need_ngo_ss_fund) {
				$biz_need_ngo_ss_fund = explode(',', $biz_need_ngo_ss_fund);
				$biz_need_ngo_supp_serv->fund_min = $biz_need_ngo_ss_fund[0];
				$biz_need_ngo_supp_serv->fund_max = $biz_need_ngo_ss_fund[1];
			}
			
			$company->biz_need_ngo_supp_serv = $biz_need_ngo_supp_serv;
		}
		else {
		    $company->bool_biz_need_ngo_supp_serv = 0;
		    $company->biz_need_ngo_supp_serv = null;
		}

		//
		// Business need Detail
		//======================
		//
		// biz_need_detail_ngo
		if ($post_values['biz_need_ngo_supp_serv'] && isset($post_values['biz_need_detail_ngo']))
		{
			$BP_BizNeedDetail = new \BP_BizNeedDetail();
			$BP_BizNeedDetail->company_id = $company->id;			
			$BP_BizNeedDetail->detail = $post_values['biz_need_detail_ngo'];
			$BP_BizNeedDetail->biz_need_type_id = \BP_BizNeedType::NGO_SUPPORT_SERVICE;

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
			'biz_need_ngo_supp_serv'			=> FILTER_VALIDATE_INT,
			'biz_need_ngo_supp_serv_org_type_1'	=> FILTER_VALIDATE_INT,
			'biz_need_ngo_supp_serv_org_type_2'	=> FILTER_VALIDATE_INT,
			'biz_need_ngo_supp_serv_type'		=> array('filter' => FILTER_CALLBACK,
		        'options' => parent::validate_checkbox_1(array(
		            'filter' => FILTER_VALIDATE_INT,
		            'flag' => FILTER_REQUIRE_SCALAR,
		        ))),
			'biz_need_ngo_supp_serv_type_other'	=> FILTER_SANITIZE_STRING,
			'biz_need_ngo_ss_fund'	=> FILTER_SANITIZE_STRING,
			'biz_need_detail_ngo'	=> FILTER_SANITIZE_STRING,
		);

		return array_merge($validators_parent, $validators);
	}
}