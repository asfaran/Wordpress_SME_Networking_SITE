<?php

require_once(__DIR__ . '/../test/wpdb.php');
require_once(__DIR__ . '/../entities/BP_File.php');
require_once(__DIR__ . '/../entities/BP_Node.php');
require_once(__DIR__ . '/../entities/BP_Score.php');
require_once(__DIR__ . '/../entities/BP_Company.php');
require_once(__DIR__ . '/../entities/wp_column_types.php');
require_once(__DIR__ . '/../includes/BP_Hydrator.php');
require_once(__DIR__ . '/../includes/BP_BaseRepository.php');
require_once(__DIR__ . '/../includes/BP_Repo_Companies.php');
require_once(__DIR__ . '/../includes/BP_Company_Filter.php');


class BP_Repository_Company_Test extends PHPUnit_Framework_TestCase
{

	/*public function test_company_update()
	{
		$wpdb = $this->getMock('wpdb');
		$wpdb->expects($this->any())->method('update')->will($this->returnValue(TRUE));
		$wpdb->expects($this->any())->method('insert')->will($this->returnValue(TRUE));
		$wpdb->expects($this->exactly(2))->method('query')->with('START TRANSACTION');
		$wpdb->expects($this->at(1))->method('__get')->with($this->equalTo('insert_id'))->will($this->returnValue(10));

		$BP_Repo_Companies = new BP_Repo_Companies($wpdb, '', 0);

		$company = new BP_Company();
		$company->comapny_name = "New company";

		$res = $BP_Repo_Companies->company_update($company);

		$this->assertTru($res);

	}*/

	public function test_create_sql_for_filter()
	{
		$wpdb = $this->getMock('wpdb');
		$BP_Repo_Companies = new BP_Repo_Companies($wpdb, '', 1);		
		
		$BP_Company_Filter = new BP_Company_Filter();		
		
		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals('SELECT c.* FROM companies c LIMIT 10', $sql);

		$BP_Company_Filter->sme_turnover_min = 500000;
		$BP_Company_Filter->sme_turnover_max = 1000000;

		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"WHERE (c.turnover_min = 500000 AND c.turnover_max = 1000000) LIMIT 10", $sql);

		$BP_Company_Filter->sme_typeof_biz = array(34, 53);
		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN company_biz_types com_biztype ON com_biztype.company_id = c.id " .
			"WHERE (c.turnover_min = 500000 AND c.turnover_max = 1000000)" .
			" OR (com_biztype.biz_type_id = 34 AND com_biztype.biz_type_id = 53) LIMIT 10", $sql);

		$BP_Company_Filter->sme_turnover_min = null;
		$BP_Company_Filter->sme_turnover_max = null;

		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN company_biz_types com_biztype ON com_biztype.company_id = c.id " .
			"WHERE " .
			"(com_biztype.biz_type_id = 34 AND com_biztype.biz_type_id = 53) LIMIT 10", $sql);

		$BP_Company_Filter->sme_employees_min = 50;
		$BP_Company_Filter->sme_employees_max = 100;

		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN company_biz_types com_biztype ON com_biztype.company_id = c.id " .
			"WHERE " .			
			"(com_biztype.biz_type_id = 34 AND com_biztype.biz_type_id = 53)" .
			" OR (c.num_employee_min = 50 AND c.num_employee_max = 100) LIMIT 10"
			, $sql);

		$BP_Company_Filter->sme_employees_max = null;
		$BP_Company_Filter->sme_turnover_min = 500000;
		$BP_Company_Filter->sme_turnover_max = 1000000;

		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN company_biz_types com_biztype ON com_biztype.company_id = c.id " .
			"WHERE " .	
			"(c.turnover_min = 500000 AND c.turnover_max = 1000000)" .
			" OR (com_biztype.biz_type_id = 34 AND com_biztype.biz_type_id = 53)" .
			" OR (c.num_employee_min = 50) LIMIT 10"
			, $sql);

		$BP_Company_Filter->partner_in_industries = array(22, 23);

		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN company_biz_types com_biztype ON com_biztype.company_id = c.id " .
			"LEFT JOIN biz_need_partner_industries bnp_ind ON bnp_ind.company_id = c.id " .			
			"WHERE " .	
			"(c.turnover_min = 500000 AND c.turnover_max = 1000000)" .
			" OR (com_biztype.biz_type_id = 34 AND com_biztype.biz_type_id = 53)" .
			" OR (c.num_employee_min = 50)" .
			" OR (bnp_ind.industry_id = 22 AND bnp_ind.industry_id = 23) LIMIT 10"
			, $sql);

		$BP_Company_Filter->sme_turnover_min = null;
		$BP_Company_Filter->sme_turnover_max = null;
		$BP_Company_Filter->partner_in_industries = array();
		$BP_Company_Filter->sme_typeof_biz = array();
		$BP_Company_Filter->country_of_incorporate = 80;
		$BP_Company_Filter->partner_in_typeof_businesses = array(33, 34, 55);

		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN biz_need_partner_biz_types bnp_biztype ON bnp_biztype.company_id = c.id " .
			"WHERE " .			
			"(c.num_employee_min = 50)" .
			" OR c.country_of_incorporate = 80" .
			" OR (bnp_biztype.biz_type_id = 33 AND bnp_biztype.biz_type_id = 34 AND bnp_biztype.biz_type_id = 55) LIMIT 10"
			, $sql);

		$BP_Company_Filter->invest_min = 3000;
		$BP_Company_Filter->invest_max = 5000;
		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN biz_need_partner_biz_types bnp_biztype ON bnp_biztype.company_id = c.id " .
			"LEFT JOIN biz_need_investments bninv ON bninv.company_id = c.id " .
			"WHERE " .			
			"(c.num_employee_min = 50)" .
			" OR c.country_of_incorporate = 80" .
			" OR (bnp_biztype.biz_type_id = 33 AND bnp_biztype.biz_type_id = 34 AND bnp_biztype.biz_type_id = 55)" .
			" OR (bninv.min = 3000 AND bninv.max = 5000) LIMIT 10"
			, $sql);

		$BP_Company_Filter->provided_services = array(55, 66);
		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN biz_need_partner_biz_types bnp_biztype ON bnp_biztype.company_id = c.id " .
			"LEFT JOIN biz_need_investments bninv ON bninv.company_id = c.id " .
			"LEFT JOIN biz_give_services bgv_serv ON bgv_serv.company_id = c.id " .
			"WHERE " .			
			"(c.num_employee_min = 50)" .
			" OR c.country_of_incorporate = 80" .
			" OR (bnp_biztype.biz_type_id = 33 AND bnp_biztype.biz_type_id = 34 AND bnp_biztype.biz_type_id = 55)" .
			" OR (bninv.min = 3000 AND bninv.max = 5000)" .
			" OR (bgv_serv.service_id = 55 AND bgv_serv.service_id = 66) LIMIT 10"
			, $sql);

		$BP_Company_Filter->provided_services = array();
		$BP_Company_Filter->invest_req_turnover_min = 1000;
		$BP_Company_Filter->invest_req_turnover_max = 10000;

		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN biz_need_partner_biz_types bnp_biztype ON bnp_biztype.company_id = c.id " .
			"LEFT JOIN biz_need_investments bninv ON bninv.company_id = c.id " .
			"WHERE " .			
			"(c.num_employee_min = 50)" .
			" OR c.country_of_incorporate = 80" .
			" OR (bnp_biztype.biz_type_id = 33 AND bnp_biztype.biz_type_id = 34 AND bnp_biztype.biz_type_id = 55)" .
			" OR (bninv.min = 3000 AND bninv.max = 5000)" .
			" OR (bninv.turnover_min = 1000 AND bninv.turnover_max = 10000) LIMIT 10"
			, $sql);

		$BP_Company_Filter->invest_req_turnover_min = null;
		$BP_Company_Filter->invest_req_turnover_max = null;
		$BP_Company_Filter->invest_in_industries = array(44, 45);

		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN biz_need_partner_biz_types bnp_biztype ON bnp_biztype.company_id = c.id " .
			"LEFT JOIN biz_need_investments bninv ON bninv.company_id = c.id " .
			"LEFT JOIN investments_industries inv_ind ON inv_ind.investment_id = bninv.id " .
			"WHERE " .			
			"(c.num_employee_min = 50)" .
			" OR c.country_of_incorporate = 80" .
			" OR (bnp_biztype.biz_type_id = 33 AND bnp_biztype.biz_type_id = 34 AND bnp_biztype.biz_type_id = 55)" .
			" OR (bninv.min = 3000 AND bninv.max = 5000)" .
			" OR (inv_ind.industry_id = 44 AND inv_ind.industry_id = 45) LIMIT 10"
			, $sql);

		$BP_Company_Filter->invest_req_years_in_biz_min = 5;
		$BP_Company_Filter->invest_req_years_in_biz_max = 10;
		$BP_Company_Filter->invest_req_turnover_min = null;
		$BP_Company_Filter->invest_req_turnover_max = null;
		$BP_Company_Filter->invest_min = null;
		$BP_Company_Filter->invest_max = null;
		$BP_Company_Filter->invest_in_industries = array();
		$BP_Company_Filter->ngo_org_type_development_agency = 1;

		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN biz_need_partner_biz_types bnp_biztype ON bnp_biztype.company_id = c.id " .
			"LEFT JOIN biz_need_investments bninv ON bninv.company_id = c.id " .
			"LEFT JOIN biz_need_ngo_supp_serv ngo ON ngo.company_id = c.id " .
			"WHERE " .			
			"(c.num_employee_min = 50)" .
			" OR c.country_of_incorporate = 80" .
			" OR (bnp_biztype.biz_type_id = 33 AND bnp_biztype.biz_type_id = 34 AND bnp_biztype.biz_type_id = 55)" .
			" OR (bninv.years_in_biz_min = 5 AND bninv.years_in_biz_max = 10)" .
			" OR (ngo.org_type_development_agency = 1) LIMIT 10"
			, $sql);

		$BP_Company_Filter->ngo_org_type_chamber_of_commerce = 1;
		$BP_Company_Filter->ngo_service_provided = array(4, 6);
		$sql = $BP_Repo_Companies->create_sql_for_filter($BP_Company_Filter);
		$this->assertEquals("SELECT c.* FROM companies c ".
			"LEFT JOIN biz_need_partner_biz_types bnp_biztype ON bnp_biztype.company_id = c.id " .
			"LEFT JOIN biz_need_investments bninv ON bninv.company_id = c.id " .
			"LEFT JOIN biz_need_ngo_supp_serv ngo ON ngo.company_id = c.id " .
			"LEFT JOIN biz_need_ngo_services ngo_serv ON ngo_serv.biz_need_ngo_id = ngo.id " .
			"WHERE " .			
			"(c.num_employee_min = 50)" .
			" OR c.country_of_incorporate = 80" .
			" OR (bnp_biztype.biz_type_id = 33 AND bnp_biztype.biz_type_id = 34 AND bnp_biztype.biz_type_id = 55)" .
			" OR (bninv.years_in_biz_min = 5 AND bninv.years_in_biz_max = 10)" .
			" OR (ngo.org_type_development_agency = 1 AND ngo.org_type_chamber_of_commerce = 1)" .
			" OR (ngo_serv.service_id = 4 AND ngo_serv.service_id = 6) LIMIT 10"
			, $sql);

	}

	public function test_create_sql_for_filter_count()
	{
		$wpdb = $this->getMock('wpdb');
		$BP_Repo_Companies = new BP_Repo_Companies($wpdb, '', 1);		
		
		$BP_Company_Filter = new BP_Company_Filter();		
		
		$sql = $BP_Repo_Companies->create_sql_for_filter_count($BP_Company_Filter);
		$this->assertEquals('SELECT COUNT(c.id) FROM companies c GROUP BY c.id', $sql);

		$BP_Company_Filter->sme_turnover_min = 500000;
		$BP_Company_Filter->sme_turnover_max = 1000000;

		$sql = $BP_Repo_Companies->create_sql_for_filter_count($BP_Company_Filter);
		$this->assertEquals("SELECT COUNT(c.id) FROM companies c ".
			"WHERE (c.turnover_min = 500000 AND c.turnover_max = 1000000) GROUP BY c.id", $sql);
	}

	public function test_create_sql_select_all_companies()
	{
		$wpdb = $this->getMock('wpdb');
		$BP_Repo_Companies = new BP_Repo_Companies($wpdb, '', 0);

		$sql = $BP_Repo_Companies->create_sql_select_all_companies(BP_Company::$table_name);
		$this->assertEquals("SELECT c.* FROM companies c LEFT JOIN scores sco ON sco.company_id = c.id GROUP BY c.id ORDER BY sco.scores", $sql);

		$sql = $BP_Repo_Companies->create_sql_select_all_companies(BP_Company::$table_name, array('user_id' => 10), array('%d'));
		$this->assertEquals("SELECT c.* FROM companies c LEFT JOIN scores sco ON sco.company_id = c.id WHERE user_id = 10 GROUP BY c.id ORDER BY sco.scores", $sql);		

		$sql = $BP_Repo_Companies->create_sql_select_all_companies(BP_Company::$table_name, 
			array('user_id' => 10, 'company_id' => 23), array('%d', '%d'));
		$this->assertEquals("SELECT c.* FROM companies c LEFT JOIN scores sco ON sco.company_id = c.id WHERE user_id = 10 AND company_id = 23 GROUP BY c.id ORDER BY sco.scores", $sql);

		$sql = $BP_Repo_Companies->create_sql_select_all_companies(BP_Company::$table_name,
			array('user_id' => 10, 'turnover_min' => 100000, 'turnover_max' => 100000000),
			array('%d', '%d', '%d'));
		$this->assertEquals(
			"SELECT c.* FROM companies c LEFT JOIN scores sco ON sco.company_id = c.id WHERE user_id = " .
			"10 AND turnover_min = 100000 AND turnover_max = 100000000 GROUP BY c.id ORDER BY sco.scores", $sql);

		$sql = $BP_Repo_Companies->create_sql_select_all_companies(BP_Company::$table_name,
			array('user_id' => 10, 'turnover_min' => 100000, 'turnover_max' => 100000000),
			array('%d', '%d', '%d'), 10, 2);
		$this->assertEquals(
			"SELECT c.* FROM companies c LEFT JOIN scores sco ON sco.company_id = c.id WHERE user_id = " .
			"10 AND turnover_min = 100000 AND turnover_max = 100000000 GROUP BY c.id ORDER BY sco.scores LIMIT 2, 10", $sql);

		$sql = $BP_Repo_Companies->create_sql_select_all_companies(BP_Company::$table_name,
			array('user_id' => 10, 'turnover_min' => 100000, 'turnover_max' => 100000000),
			array('%d', '%d', '%d'), 2);
		$this->assertEquals(
			"SELECT c.* FROM companies c LEFT JOIN scores sco ON sco.company_id = c.id WHERE user_id = " .
			"10 AND turnover_min = 100000 AND turnover_max = 100000000 GROUP BY c.id ORDER BY sco.scores LIMIT 2", $sql);

	}

}
