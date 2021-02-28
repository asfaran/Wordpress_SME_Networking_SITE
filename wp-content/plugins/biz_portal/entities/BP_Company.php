<?php
/**
 * Class BP_Company
 * 
 * The main class for the company holding all sub classes and relations
 * within it.
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_Company
{
	/** 
	 * @var int $id 
	 */
    public $id;
    
    /** 
     * User ID to whome this company belongs to.
     * @var int $user_id
     */
    public $user_id;
    
    /** 
     * Name of the company.
     * @var string $name
     */
    public $company_name;
    
    /** 
     * Country of incorporate.
     * @var int $country_of_incorporate
     */
    public $country_of_incorporate;

    /**
     * Registration number.
     * @var string $reg_number
     */
    public $reg_number;
    
    /** 
     * Year of incorporate.
     * @var int $year_of_incorporate
     */
    public $year_of_incorporate;
    
    /** 
     * Location of head office.
     * @var string $location_head_office
     */
    public $location_head_office;
    
    /** 
     * CEO or MD name.
     * @var string $ceo_md
     */
    public $ceo_md;
    
    /**
     * @var string $ceo_md_designation CEO or MD designation (lately added for the requirement of direcotry specific data)
     */
    public $ceo_md_designation;
    
    /**
     * @var string $corporate_type corporate type/member type (lately added for the requirement of direcotry specific data)
     */
    public $corporate_type;
    
    /**
     * Other branches if available .
     * @var string $other_branch
     * */
    public $other_branch;
        
    /** 
     * Turnover max value.
     * @var int $turnover_min
     */
    public $turnover_min;
    
    /** 
     * Turnover min value.
     * @var int $turnover_max
     */
    public $turnover_max;
    
    /** 
     * Number of employee min value.
     * @var int $num_employee_min
     */
    public $num_employee_min;
    
    /** 
     * Number of employee max value.
     * @var int $num_employee_max
     */
    public $num_employee_max;
    
    /** 
     * Member type id.
     * @var string $member_type_id
     */
    public $member_type_id;
    
    /** 
     * Is company active.
     * @var int $active
     */
    public $active;
    
    /** 
     * Created date.
     * @var string $created
     */
    public $created;

    /**
     * Last update
     * @var timestamp $last_update
     */
    public $last_update;
    
    /** 
     * Summary of company.
     * @var string $summary
     */
    public $summary;
    
    /**
     * 
     * @var int
     */
    public $terms_accepted;
    
    /** 
     * Should need or can be business partner
     * @var bool|int $bool_biz_need_partner_in
     */
    public $bool_biz_need_partner_in;
    
    /** 
     * Should need or provide business service.
     * @var bool|int $bool_biz_need_service
     */
    public $bool_biz_need_service;
    
    /** 
     * Should need or make invest.
     * @var bool|int $bool_biz_need_invest
     */
    public $bool_biz_need_invest;
    
    /** 
     * Provide support/service as NGO.
     * var bool|int $bool_biz_need_ngo_supp_serv
     */
    public $bool_biz_need_ngo_supp_serv;
    
    /**
     * 
     * @var bool|int $bool_biz_give_service
     */
    public $bool_biz_give_service;
    
    /**
     * 
     * @var bool|int $bool_biz_give_invest
     */
    public $bool_biz_give_invest;
    
    //===================================
    //===================================

    /**
     * @var BP_Country $country
     */
    public $country;
    
    /**
     * 
     * @var array BP_BizService $biz_need_services
     */
    public $biz_need_services;
    
    /**
     *
     * @var array BP_BizService $biz_give_services
     */
    public $biz_give_services;

    /**
     * 
     * @var array BP_BizType $biz_need_partner_biz_types
     */
    public $biz_need_partner_biz_types;

    /**
     * @var array BP_Industry $biz_need_partner_industries
     */
    public $biz_need_partner_industries;

    /**
     * @var BP_BizNeedNGOSuppServ $biz_need_ngo_supp_serv
     */
    public $biz_need_ngo_supp_serv;

    /**
     * @var BP_BizNeedInvestment $biz_need_investment
     */
    public $biz_need_investment;
    
    /**
     * @var BP_BizNeedInvestment $biz_give_investment
     */
    public $biz_give_investment;

    /**
     * @var array BP_Contact $contacts
     */
    public $contacts;

    /**
     * @var array BP_BizType $biz_types 
     */
    public $biz_types;

    /**
     * @var array BP_Address $addresses
     */
    public $addresses;

    /**
     * @var array BP_Industry $industries
     */
    public $industries;

    /**
     * @var array BP_BizNeedDetail $biz_need_details
     */
    public $biz_need_details;
    
    /**
     * @var BP_CompanyProfile $profile
     */
    public $profile;

    /**
     * @var BP_MemberType $member_type
     */
    public $member_type;
    
    
    /**
     * Table name.
     * @var string $table_name
     */
    public static $table_name = 'companies';

    /**
     * Class constructor
     */
    public function __construct() {
        $this->id = 0;
        $this->active = 0;
        $this->ceo_md_designation = '';
        $this->corporate_type = '';
        $this->bool_biz_need_partner_in      = 0;
        $this->bool_biz_need_service         = 0;
        $this->bool_biz_need_invest          = 0;
        $this->bool_biz_need_ngo_supp_serv   = 0;
        $this->bool_biz_give_invest          = 0;
        $this->bool_biz_give_service         = 0;
        $this->created      = date("Y-m-d H:i:s");

        $this->contacts     = array();
        $this->addresses    = array();
        $this->industries   = array();
        $this->biz_need_details         = array();
        $this->biz_need_services        = array();
        $this->biz_give_services        = array();
        $this->biz_need_partner_biz_types = array();
        $this->biz_need_partner_industries = array();
        $this->biz_types = array();
        
    }
    
    /**
     * Convert the class properties in to array
     * 
     * @return array
     */
    public function to_array()
    {
    	return array(
	    	'id' => $this->id,
	    	'user_id' => $this->user_id,
	    	'company_name' => $this->company_name,
	    	'country_of_incorporate' => $this->country_of_incorporate,
            'reg_number' => $this->reg_number,
	    	'year_of_incorporate' => $this->year_of_incorporate,
	    	'location_head_office' => $this->location_head_office,
	    	'ceo_md' => $this->ceo_md,
    	    'ceo_md_designation' => $this->ceo_md_designation,
	    	'other_branch' => $this->other_branch,
	    	'turnover_min' => $this->turnover_min,
	    	'turnover_max' => $this->turnover_max,
	    	'num_employee_min' => $this->num_employee_min,
	    	'num_employee_max' => $this->num_employee_max,
	    	'member_type_id' => $this->member_type_id,
	    	'active' => $this->active,
	    	'created' => $this->created,
	    	'summary' => $this->summary,
    	    'terms_accepted' => $this->terms_accepted,
	    	'bool_biz_need_partner_in' => $this->bool_biz_need_partner_in,
	    	'bool_biz_need_service' => $this->bool_biz_need_service,
	    	'bool_biz_need_invest' => $this->bool_biz_need_invest,
	    	'bool_biz_need_ngo_supp_serv' => $this->bool_biz_need_ngo_supp_serv,
            'bool_biz_give_service' => $this->bool_biz_give_service,
            'bool_biz_give_invest' => $this->bool_biz_give_invest,
	    );
    }    
    
    /**
     * Add contacts
     * 
     * @param BP_Contact $contact
     */
    public function add_contact(BP_Contact $contact) {
        $this->contacts[] = $contact;
    }
    
    /**
     * Add addresses
     * 
     * @param BP_Address $address
     */
    public function add_address(BP_Address $address) {
        $this->addresses[] = $address;
    }

    /**
     * Add Industry
     * 
     * @param BP_Industry $industry
     */
    public function add_industry(BP_Industry $industry) {
        $this->industries[] = $industry;
    }
    
    /**
     * Add business needs services
     * 
     * @param BP_BizService $biz_need_service
     */
    public function add_biz_need_service(BP_BizService $biz_need_service){
    	$this->biz_need_services[] = $biz_need_service;
    }

    /**
     * Add business types
     * @param BP_BizType $biz_type
     */
    public function add_biz_type(BP_BizType $biz_type) {
        $this->biz_types[] = $biz_type;
    }
}
