<?php

require_once (__DIR__ . '/../entities/BP_MemberType.php');
require_once (__DIR__ . '/../entities/BP_Company.php');
require_once (__DIR__ . '/../entities/BP_Contact.php');
require_once (__DIR__ . '/../entities/BP_Address.php');
require_once (__DIR__ . '/../entities/BP_Industry.php');
require_once (__DIR__ . '/../entities/BP_BizType.php');
require_once (__DIR__ . '/../entities/BP_MemberType.php');
require_once (__DIR__ . '/../entities/BP_BizService.php');
require_once (__DIR__ . '/../entities/BP_BizNeedNGOSuppServ.php');
require_once (__DIR__ . '/../entities/BP_BizNeedInvestment.php');

require_once (__DIR__ . '/../signup/Signup_Abstract.php');
require_once (__DIR__ . '/../signup/Local.php');
require_once (__DIR__ . '/../signup/International.php');

class BP_Signup_Test extends PHPUnit_Framework_TestCase
{
	private $data_arg = array();

	public function test_execute_international()
	{
		$signup_internationl = new bp\signup\International(2, BP_MemberType::TYPE_INTL);

		$validators = $signup_internationl->get_validators();

		$company = new BP_Company();
		$post_values = filter_var_array($this->data_arg, $validators);
		$company = $signup_internationl->execute_post($company, $post_values);

		$this->assertEquals(23, $company->id);
		$this->assertEquals("Johnson & Johnson Bro.", $company->company_name);
		$this->assertEquals("2334/3434dfd/1982", $company->reg_number);
		$this->assertEquals("45", $company->country_of_incorporate);
		$this->assertEquals(1000, $company->turnover_min);
		$this->assertEquals(100000, $company->turnover_max);
		$this->assertEquals(50, $company->num_employee_min);
		$this->assertEquals(500, $company->num_employee_max);
		$this->assertEquals("Bob Martin", $company->contacts[0]->contact_person);
		$this->assertEquals("bob_margin@gmail.com", $company->contacts[0]->email);

		$this->assertEquals(4545, $company->addresses[0]->number);
		$this->assertEquals("Business bay street, ", $company->addresses[0]->street);
		$this->assertEquals(5, $company->industries[0]->id);
		$this->assertEquals(7, $company->industries[1]->id);

		$this->assertEquals(55, $company->biz_types[0]->id);
		$this->assertEquals(7, $company->biz_types[3]->id);
		//$this->assertArrayNotHasKey(4, $company->biz_types);
		$this->assertEquals("Software", $company->biz_types[4]->type_text);

		$this->assertEquals(33, $company->biz_need_partner_biz_types[1]->id);
		$this->assertEquals(34, $company->biz_need_partner_biz_types[0]->id);
		$this->assertEquals("national service", $company->biz_need_partner_biz_types[3]->type_text);

		$this->assertEquals(57, $company->biz_need_partner_industries[1]->id);
		$this->assertEquals(88, $company->biz_need_partner_industries[3]->id);
		$this->assertEquals("national industry", $company->biz_need_partner_industries[4]->ind_name);

		$this->assertEquals(1, $company->bool_biz_give_invest);
		$this->assertEquals(10000000, $company->biz_give_investment->min);
		$this->assertEquals(0, $company->biz_give_investment->max);
		$this->assertEquals(0, $company->biz_give_investment->sme_employee_min);
		$this->assertEquals(50, $company->biz_give_investment->sme_employee_max);
		$this->assertEquals(20, $company->biz_give_investment->years_in_biz_max);

		$this->assertTrue((bool)$company->bool_biz_give_service);
		$this->assertFalse((bool)$company->bool_biz_need_service);

		$this->assertEquals(23, $company->biz_give_services[0]->id);
		$this->assertEquals(34, $company->biz_give_services[1]->id);

		$this->assertEquals(0, $company->biz_need_ngo_supp_serv->fund_min);
		$this->assertEquals(100000, $company->biz_need_ngo_supp_serv->fund_max);
		$this->assertEquals(54, $company->biz_need_ngo_supp_serv->services_provided[2]->id);
		
	}

	public function setUp()
	{
		$this->data_arg = array(
			'id'					=> 23,
			'company_name' 			=> "Johnson & Johnson Bro.",
			'reg_number'			=> "2334/3434dfd/1982",
			'country_of_incorporate'=> "45",
			'year_of_incorporate' 	=> "1982",
			'location_head_office' 	=> "Dubai",
			'ceo_md' 			=> "John Watson",
			'other_branch' 		=> "London",
			'turnover' 			=> "1000,100000",
			'num_employee' 		=> "50,500",
			'summary'			=> "This is a fast growing company based on Dubai.",
			'contact_person'	=> "Bob Martin",
			'contact_position'	=> "Marketing Manager",
			'contact_telephone'	=> "066634343",
			'contact_fax'		=> "066734343",
			'contact_web'		=> "http://wwww.noweb.it",
			'contact_mobile'	=> "0773434343",
			'contact_email'		=> "bob_margin@gmail.com",
			'address_number'	=> "4545",
			'address_city'		=> "Dubai",
			'address_region'	=> "Dubai Region",
			'address_street'	=> "Business bay street, <script>",
			'address_postal_code'	=> "111580",
			'address_country'	=> "66",
			'company_industries'	=> array(0=>5,1=>7),
			'company_biz_types'	=> array(0=>55,1=>34,2=>5,3=>7,4=>"df3"),
			'company_biz_types_other' 	=> "Software",
			'biz_need_partner'			=> "1",
			'biz_needs_partner_in' 		=> array(0=>34,1=>33,2=>55),
			'biz_needs_partner_other'	=> "national service",
			'biz_needs_partner_in_ind' 	=> array(0=>55,1=>57,2=>2,3=>88),
			'biz_needs_partner_in_ind_other'	=> "national industry",
			'biz_need_invest'			=> "1",
			'biz_need_invest_amount'	=> "10000000,0",
			'biz_need_invest_emp_size'	=> "0,50",
			'biz_need_invest_ind' => array(0=>34,1=>56,2=>78),
			'biz_need_invest_ind_other'	=> "Airlines",
			'biz_need_invest_turnover'	=> "5000000,500000000",
			'biz_need_invest_turnover_other'	=> "",
			'biz_need_invest_yrs'		=> "10,20",
			'biz_need_invest_yrs_other'	=> "",
			'biz_needs_service_provide_bool'	=> "1",
			'biz_needs_service_provide' => array(0=>23,1=>34,2=>56,3=>67,4=>45),
			'biz_needs_service_provide_other'	=> "Account Consultancy",	
			'biz_need_ngo_supp_serv'			=> "1",
			'biz_need_ngo_supp_serv_org_type_1'	=> "1",
			'biz_need_ngo_supp_serv_org_type_2'	=> "1",
			'biz_need_ngo_supp_serv_type'		=> array(0=>23,1=>24,2=>54),
			'biz_need_ngo_supp_serv_type_other'	=> "Food Service",
			'biz_need_ngo_ss_fund'	=> "0,100000",		
		);
	}
}