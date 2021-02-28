<?php

class BP_Company_Filter
{
    //sme
	public $sme_turnover = array();
	public $sme_employee = array();
	public $sme_typeof_biz = array();	
	public $industries = array(); // busines_partner
	//business_partner
	public $country_of_incorporate = array();
	public $do_invest = array();
	public $partner_in_industries = array();
	public $partner_in_typeof_businesses = array();
	//service provider
	public $provided_services = array();
	//invest
	public $invest_in_industries = array();
	public $invest_req_turnover = array();
	public $invest_req_years_biz = array();
	
	
	public $ngo_org_type_development_agency = null;
	public $ngo_org_type_chamber_of_commerce = null;
	public $ngo_service_provided = array();
	
	public $member_type = null;
	
	public $bool_biz_need_partner_in = false;
	public $bool_biz_give_service = false;
	public $bool_biz_give_invest = false;
	public $bool_biz_need_ngo_supp_serv = false;
	/**
	 * @var bool $find_only_acive Find only active company
	 */
	public $find_only_acive;


	private $var_has_filter;
	private $var_has_own_filter;
	
	
	/**
	 * Arrays of values for turnover SME
	 */
	public $turnover_values = array(
	        array('value' => "0,500000",'text' => "Under US$500,000",'value_min' => 0,'value_max' => 500000),
	        array('value' => "500001,1000000",'text' => "US$500,001 - 1,000,000",'value_min' => 500001,'value_max' => 1000000),
	        array('value' => "1000001,2000000",'text' => "US$1,000,001 - 2,000,000",'value_min' => 1000001,'value_max' => 2000000),
	        array('value' => "2000000,0",'text' => "Over US$2,000,000",'value_min' => 2000000,'value_max' => 0),
	        array('value' => "0,0",'text' => "Undisclosed",'value_min' => 0,'value_max' => 0),
	);
	
	/**
	 * Arrays of values for turnover International
	 */
	public $turnover_values_intl = array(
	        array('value' => "0,1000000",'text' => "Under US$1,000,000",'value_min' => 0,'value_max' => 1000000),
	        array('value' => "1000001,10000000",'text' => "US$1,000,001 - 10,000,000",'value_min' => 1000001,'value_max' => 10000000),
	        array('value' => "10000001,50000000",'text' => "US$10,000,001 - 50,000,000",'value_min' => 10000001,'value_max' => 50000000),
	        array('value' => "50000000,0",'text' => "Over US$50,000,000",'value_min' => 50000000,'value_max' => 0),
	        array('value' => "0,0",'text' => "Undisclosed",'value_min' => 0,'value_max' => 0),
	);
	
	/**
	 * Array of values for Invest turnover requrement
	 * @var unknown_type
	 */
	public $invest_turnover_values = array(
	        array('value' => '0,1000000', 'text' => 'Up to US$1,000,000', 'value_min' => 0, 'value_max' => 1000000),
	        array('value' => '1000001,2000000', 'text' => 'US$1,000,001 - 2,000,000', 'value_min' => 1000001, 'value_max' => 2000000),
	        array('value' => '2000001,5000000', 'text' => 'US$2,000,001 - 5,000,000', 'value_min' => 2000001, 'value_max' => 5000000),
	        array('value' => '5000000,0', 'text' => 'Over 5,000,000', 'value_min' => 5000000, 'value_max' => 0),
	        array('value' => '0,0', 'text' => 'No Requirement', 'value_min' => 0, 'value_max' => 0),
	);
	
	/**
	 * Number of employees array SME
	 */
	public $number_of_employees = array(
	        array('value' => "1,50", 'text' => "1 - 50", 'value_min' => 1, 'value_max' => 50),
	        array('value' => "51,100", 'text' => "51 - 100", 'value_min' => 51, 'value_max' => 100),
	        array('value' => "101,200", 'text' => "101 - 200", 'value_min' => 101, 'value_max' => 200),
	        array('value' => "200,0", 'text' => "Over 200", 'value_min' => 200, 'value_max' => 0),
	);
	
	/**
	 * Number of employees array international
	 */
	public $number_of_employees_intl = array(
	        array('value' => "1,100", 'text' => "Less than 100", 'value_min' => 1, 'value_max' => 100),
	        array('value' => "101,200", 'text' => "101 - 200", 'value_min' => 101, 'value_max' => 200),
	        array('value' => "201,500", 'text' => "201 - 500", 'value_min' => 201, 'value_max' => 500),
	        array('value' => "500,0", 'text' => "Over 500", 'value_min' => 500, 'value_max' => 0),
	);
	
	/**
	 * Arrays of invest amount
	 */
	public $invest_amount_values = array(
	        array('value' => "0,1000000",'text' => "US$1,000,000",'value_min' => 0,'value_max' => 1000000),
	        array('value' => "1000001,2000000",'text' => "US$1,000,001 - 2,000,000",'value_min' => 1000001,'value_max' => 2000000),
	        array('value' => "2000001,5000000",'text' => "US$2,000,001 - 5,000,000",'value_min' => 2000001,'value_max' => 5000000),
	        array('value' => "5000000,0",'text' => "Over 5,000,000",'value_min' => 5000000,'value_max' => 0),
	        array('value' => "0,0",'text' => "No Requirement",'value_min' => 0,'value_max' => 0),
	);
	
	/**
	 * Array years in business
	 */
	public $years_in_business = array(
	        array('value' => "0,2", 'text' => "0 - 2 Years", 'value_min' => 0,'value_max' => 2),
	        array('value' => "2,5", 'text' => "2 - 5 Years", 'value_min' => 2,'value_max' => 5),
	        array('value' => "5,10", 'text' => "5 - 10 Years", 'value_min' => 5,'value_max' => 10),
	        array('value' => "10,0", 'text' => "Over 10 Years", 'value_min' => 10,'value_max' => 0),
	);
	
		
	/**
	 * Tell a give min and max value belongs to the given array 
	 * 
	 * @param array $selected_array
	 * @param int $min
	 * @param int $max
	 */
	public function is_min_max_selected($selected_array, $min, $max)
	{
	    foreach ($selected_array as $value) {
	        if ($value['min'] == $min && $value['max'] == $max)
	            return true;
	    }
	    return false;
	}
	
	/**
	 * Find by active or inactive
	 * 
	 * @param bool $find_by_active
	 */
	public function __construct($find_by_active = true) 
	{
	    $this->find_only_acive = $find_by_active;
	}
	
	/**
	 * Exchange the filtered post variables with properties
	 * 
	 * @param array $post_values
	 */
	public function exchange_array($post_values)
	{
	    // SME
	    if (isset($post_values['filter_industry']) && count($post_values['filter_industry']) > 0) {
	        $this->industries = array_values($post_values['filter_industry']);
	    }
	    if (isset($post_values['filter_type_business']) && count($post_values['filter_type_business']) > 0) {
	        $this->sme_typeof_biz = array_values($post_values['filter_type_business']);
	    }
	    if (isset($post_values['filter_turnover']) && count($post_values['filter_turnover']) > 0) {
	        $filter_turnover = array_values($post_values['filter_turnover']);	        
	        foreach ($filter_turnover as $values) {            
	            list($min, $max) = array_values(explode(',', $values));
	            if (!is_null($min) && !is_null($max)) {
	                $this->sme_turnover[] = array('min' => floatval($min), 'max' => floatval($max));
	            }
	        }
	    }
	    if (isset($post_values['filter_number_employees']) && count($post_values['filter_number_employees']) > 0) {
	        $filter_emp = array_values($post_values['filter_number_employees']);
	        foreach ($filter_emp as $value)
	        {
	            list($min, $max) = array_values(explode(',', $value));
	            if (!is_null($min) && !is_null($max)) {
	                $this->sme_employee[] = array('min' => intval($min), 'max' => intval($max));
	            }
	        }
	    }
	    
	    if (isset($post_values['filter_partner_industry']) && count($post_values['filter_partner_industry']) > 0) {
	        $this->partner_in_industries = array_values($post_values['filter_partner_industry']);
	    }
	    if (isset($post_values['filter_partner_type_business']) && count($post_values['filter_partner_type_business']) > 0) {
	        $this->partner_in_typeof_businesses = array_values($post_values['filter_partner_type_business']);
	    }
	    if (isset($post_values['filter_country']) && count($post_values['filter_country']) > 0) {
	        foreach ($post_values['filter_country'] as $value) {
	            $this->country_of_incorporate[] = $value;
	        }
	    }
	    if (isset($post_values['filter_do_invest']) && count($post_values['filter_do_invest']) > 0) {
	        $filter_do_invest = array_values($post_values['filter_do_invest']);
	        foreach ($filter_do_invest as $value) {
	            list($min, $max) = array_values(explode(',', $value));
	            if (!is_null($min) && !is_null($max) && ($min > 0 || $max > 0)) {
	                $this->do_invest[] = array('min' => floatval($min), 'max' => floatval($max));
	            }
	        }
	    }
	    if (isset($post_values['filter_provide_services']) && count($post_values['filter_provide_services']) > 0) {
	        $filter_provide_service = array_values($post_values['filter_provide_services']);
	        foreach ($filter_provide_service as $value) {
	            $this->provided_services[] = $value;
	        }
	    }
	    
	    if (isset($post_values['filter_invest_in_industries']) && count($post_values['filter_invest_in_industries']) > 0) {
	        $filter_invest_industries = array_values($post_values['filter_invest_in_industries']);
	        foreach ($filter_invest_industries as $value) {
	            $this->invest_in_industries[] = $value;
	        }
	    }	    
	    
	    if (isset($post_values['filter_invest_req_turnover']) && count($post_values['filter_invest_req_turnover']) > 0) {
	        $filter_invest_req_turnover = array_values($post_values['filter_invest_req_turnover']);
	        foreach ($filter_invest_req_turnover as $value) {
	            list($min, $max) = array_values(explode(',', $value));
	            if (!is_null($min) && !is_null($max)) {
	                $this->invest_req_turnover[] = array('min' => floatval($min), 'max' => floatval($max));
	            }
	        }
	    }
	    
	    if (isset($post_values['filter_invest_req_years_biz']) && count($post_values['filter_invest_req_years_biz']) > 0) {
	        $filter_invest_req_years_biz = array_values($post_values['filter_invest_req_years_biz']);
	        foreach ($filter_invest_req_years_biz as $value) {
	            list($min, $max) = array_values(explode(',', $value));
	            if (!is_null($min) && !is_null($max)) {
	                $this->invest_req_years_biz[] = array('min' => floatval($min), 'max' => floatval($max));
	            }
	        }
	    }
	    
	    if (isset($post_values['filter_ngo_type']) && count($post_values['filter_ngo_type']) > 0) {
	        $filter_ngo_type = array_values($post_values['filter_ngo_type']);	        
	        foreach ($filter_ngo_type as $type) {
	            if ($type === 'ngo_org_type_development_agency')
	                $this->ngo_org_type_development_agency = 1;
	            else if ($type === 'ngo_org_type_chamber_of_commerce') 
	                $this->ngo_org_type_chamber_of_commerce = 1;
	        }
	    }
	    
	    if (isset($post_values['filter_ngo_services']) && count($post_values['filter_ngo_services']) > 0) {
	        $filter_ngo_services = array_values($post_values['filter_ngo_services']);
	        foreach ($filter_ngo_services as $service) {
	            $this->ngo_service_provided[] = $service;
	        }
	    }
	    
	}
	
	public function has_filter()
	{
		if ($this->find_only_acive == true
		    || $this->member_type != null		    
			|| $this->ngo_org_type_development_agency != null
			|| $this->ngo_org_type_chamber_of_commerce != null
		    || $this->bool_biz_need_partner_in == true
		    || $this->bool_biz_give_service == true
		    || $this->bool_biz_give_invest == true
	        || !$this->is_empty($this->country_of_incorporate)
	        || !$this->is_empty($this->sme_employee)
	        || !$this->is_empty($this->sme_turnover)
	        || !$this->is_empty($this->industries)
	        || !$this->is_empty($this->sme_typeof_biz)
		    || !$this->is_empty($this->do_invest)
			|| !$this->is_empty($this->ngo_service_provided) 
			|| !$this->is_empty($this->partner_in_industries)
			|| !$this->is_empty($this->partner_in_typeof_businesses)
			|| !$this->is_empty($this->invest_in_industries)
		    || !$this->is_empty($this->invest_req_turnover)
		    || !$this->is_empty($this->invest_req_years_biz)
			|| !$this->is_empty($this->provided_services)
		    )
		{
			$this->var_has_filter = true;
		}
		else 
			$this->var_has_filter = false;

		return $this->var_has_filter;
	}
	
	public function has_own_filter()
	{
	}
	
	/**
	 * Returns validators
	 * 
	 * @return array
	 */
	public function get_validators()
	{
	    return array(
	            'filter_industry' => array( 'filter' => FILTER_VALIDATE_INT,
                           'flags'  => FILTER_REQUIRE_ARRAY,
                 ),
	            'filter_type_business' => array( 'filter' => FILTER_VALIDATE_INT,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),
	            'filter_turnover' => array( 'filter' => FILTER_SANITIZE_STRING,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),
	            'filter_number_employees' => array( 'filter' => FILTER_SANITIZE_STRING,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),	        
	            'filter_country' => array( 'filter' => FILTER_VALIDATE_INT,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),	
	            'filter_partner_type_business' => array( 'filter' => FILTER_VALIDATE_INT,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),	
	            'filter_partner_industry' => array( 'filter' => FILTER_VALIDATE_INT,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),
	            'filter_do_invest' => array( 'filter' => FILTER_SANITIZE_STRING,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),
	            'filter_provide_services' => array( 'filter' => FILTER_VALIDATE_INT,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ), 
	            'filter_invest_in_industries' => array( 'filter' => FILTER_VALIDATE_INT,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),  
	            'filter_invest_req_turnover' => array( 'filter' => FILTER_SANITIZE_STRING,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),  
	            'filter_invest_req_years_biz' => array( 'filter' => FILTER_SANITIZE_STRING,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),
	            'filter_ngo_type' => array( 'filter' => FILTER_SANITIZE_STRING,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),
	            'filter_ngo_services' => array( 'filter' => FILTER_VALIDATE_INT,
	                    'flags'  => FILTER_REQUIRE_ARRAY,
	            ),
	      );
	}

	/**
	 * SME Turnover
	 */
	public function has_sme_turnover_value()
	{
		if (!$this->is_empty($this->sme_turnover))
		{
			return true;
		}
		return false;
	}

	/**
	 * SME type of business
	 */
	public function has_sme_typeof_biz()
	{
		if (count($this->sme_typeof_biz) > 0)
			return true;
	}
	
	/**
	 * SME Industries
	 */
	public function has_sme_industries()
	{
	    if (count($this->industries) > 0)
	        return true;
	}	

	/**
	 * SME Number of employee
	 */
	public function has_sme_numberof_employees()
	{
		if (!$this->is_empty($this->sme_employee))
		{
			return true;
		}

		return false;
	}

	/**
	 * Do Invest
	 */
	public function do_invest()
	{
		if (!$this->is_empty($this->do_invest))
		{
			return true;
		}

		return false;
	}

	/**
	 * has invest turnover requirements
	 */
	public function has_invest_req_turnover()
	{
		if (!$this->is_empty($this->invest_req_turnover))
		{
			return true;
		}

		return false;
	}

	/**
	 * has requirement to invest year in business
	 */
	public function has_invest_req_years_in_biz()
	{
		if (!$this->is_empty($this->invest_req_years_biz))
		{
			return true;
		}

		return false;
	}

	/**
	 * has NGO organization type
	 */
	public function has_ngo_organization_type()
	{
		if ($this->ngo_org_type_development_agency > 0
			|| $this->ngo_org_type_chamber_of_commerce > 0)
		{
			return true;
		}

		return false;
	}

	private function is_empty($array)
	{
		if (is_array($array) && count($array) > 0)
			return false;
		else
			return true;
	}
}