<?php
/**
 * Class BP_Contact
 *
 * @package entites
 * @author SWISS BUREAU
 */

class BP_BizNeedNGOSuppServ
{
	/** @var int Identifier */
	public $id;
	
	/** @var int Is a development agency org */
	public $org_type_development_agency;
	
	/** @var int Is a Chamber of commerce org type */
	public $org_type_chamber_of_commerce;
			
	/** @var int funding provided min value */
	public $fund_min;
	
	/** @var int funding provided max value */
	public $fund_max;
	
	/** @var int Company ID */
	public $company_id;

	/**
	 * @var BP_Company Company this belongs to
	 */
	public $company;

	/** @var string Table name */
	public static $table_name = 'biz_need_ngo_supp_serv';



	//
	// =================
	//
	/**
	 * @var array BP_Service $services_provided 
	 */
	public $services_provided;	



	/**
	 * Class construct
	 * 
	 * @param int $id
	 */
	public function __construct($id = 0) {
		$this->id = $id;
		$this->services_provided = array();
	}

	/**
	 * Add services typs
	 *
	 * @param BP_BizService $service
	 */
	public function add_services_provided(BP_BizService $service)
	{
		$this->services_provided[] = $service;
	}
	
	/**
	 * Convert this class to array
	 * 
	 * @return array
	 */
	public function to_array()
	{
		return array(
			'id' => $this->id,
			'org_type_development_agency' => $this->org_type_development_agency,
			'org_type_chamber_of_commerce' => $this->org_type_chamber_of_commerce,
			'fund_min' => $this->fund_min,
			'fund_max' => $this->fund_max,
			'company_id' => $this->company_id,
		);
	}
}