<?php

require_once(__DIR__ . '/../test/wpdb.php');
require_once(__DIR__ . '/../entities/BP_File.php');
require_once(__DIR__ . '/../entities/BP_Node.php');
require_once(__DIR__ . '/../entities/BP_Company.php');
require_once(__DIR__ . '/../includes/BP_Hydrator.php');
require_once(__DIR__ . '/../includes/BP_BaseRepository.php');

class BP_BaseRepository_Test extends PHPUnit_Framework_TestCase
{
	public function test_create_sql_select_all()
	{
		$wpdb = $this->getMock('wpdb');
		$BP_BaseRepository = new BP_BaseRepository($wpdb, 'wp_portal_');

		$sql = $BP_BaseRepository->create_sql_select_all(BP_Company::$table_name);
		$this->assertEquals("SELECT * FROM wp_portal_companies", $sql);

		$sql = $BP_BaseRepository->create_sql_select_all(BP_Company::$table_name, array('user_id' => 10), array('%d'));
		$this->assertEquals("SELECT * FROM wp_portal_companies WHERE user_id = 10", $sql);		

		$sql = $BP_BaseRepository->create_sql_select_all(BP_Company::$table_name, 
			array('user_id' => 10, 'company_id' => 23), array('%d', '%d'));
		$this->assertEquals("SELECT * FROM wp_portal_companies WHERE user_id = 10 AND company_id = 23", $sql);

		$sql = $BP_BaseRepository->create_sql_select_all(BP_Company::$table_name,
			array('user_id' => 10, 'turnover_min' => 100000, 'turnover_max' => 100000000),
			array('%d', '%d', '%d'));
		$this->assertEquals(
			"SELECT * FROM wp_portal_companies WHERE user_id = " .
			"10 AND turnover_min = 100000 AND turnover_max = 100000000", $sql);

		$sql = $BP_BaseRepository->create_sql_select_all(BP_Company::$table_name,
			array('user_id' => 10, 'turnover_min' => 100000, 'turnover_max' => 100000000),
			array('%d', '%d', '%d'), 10, 2);
		$this->assertEquals(
			"SELECT * FROM wp_portal_companies WHERE user_id = " .
			"10 AND turnover_min = 100000 AND turnover_max = 100000000 LIMIT 2, 10", $sql);

		$sql = $BP_BaseRepository->create_sql_select_all(BP_Company::$table_name,
			array('user_id' => 10, 'turnover_min' => 100000, 'turnover_max' => 100000000),
			array('%d', '%d', '%d'), 2);
		$this->assertEquals(
			"SELECT * FROM wp_portal_companies WHERE user_id = " .
			"10 AND turnover_min = 100000 AND turnover_max = 100000000 LIMIT 2", $sql);

	}

	public function test_create_sql_select_count()
	{
		$wpdb = $this->getMock('wpdb');
		$BP_BaseRepository = new BP_BaseRepository($wpdb, 'wp_portal_');

		$sql = $BP_BaseRepository->create_sql_select_count(BP_Company::$table_name);
		$this->assertEquals("SELECT COUNT(*) FROM wp_portal_companies", $sql);

		$sql = $BP_BaseRepository->create_sql_select_count(BP_Company::$table_name, 
			array('user_id' => 10), array('%d'));
		$this->assertEquals("SELECT COUNT(*) FROM wp_portal_companies WHERE user_id = 10", $sql);		

		$sql = $BP_BaseRepository->create_sql_select_count(BP_Company::$table_name, 
			array('user_id' => 10, 'company_id' => 23),
			array('%d', '%d'));
		$this->assertEquals("SELECT COUNT(*) FROM wp_portal_companies WHERE user_id = 10 AND company_id = 23", $sql);

		$sql = $BP_BaseRepository->create_sql_select_count(BP_Company::$table_name,
			array('user_id' => 10, 'turnover_min' => 100000, 'turnover_max' => 100000000),
			array('%d', '%d', '%d'));
		$this->assertEquals(
			"SELECT COUNT(*) FROM wp_portal_companies WHERE user_id = " .
			"10 AND turnover_min = 100000 AND turnover_max = 100000000", $sql);

		$sql = $BP_BaseRepository->create_sql_select_count(BP_Company::$table_name,
			array('user_id' => 10, 'turnover_min' => 100000, 'turnover_max' => 100000000),
			array('%d', '%d', '%d'), 10, 2);
		$this->assertEquals(
			"SELECT COUNT(*) FROM wp_portal_companies WHERE user_id = " .
			"10 AND turnover_min = 100000 AND turnover_max = 100000000", $sql);

		$sql = $BP_BaseRepository->create_sql_select_count(BP_Company::$table_name,
			array('user_id' => 10, 'turnover_min' => 100000, 'turnover_max' => 100000000),
			array('%d', '%d', '%d'), 2);
		$this->assertEquals(
			"SELECT COUNT(*) FROM wp_portal_companies WHERE user_id = " .
			"10 AND turnover_min = 100000 AND turnover_max = 100000000", $sql);
	}

	public function test_map_result()
	{
		$data_array = $this->get_sample_data();

		$wpdb = $this->getMock('wpdb');

		$BP_Repo_Companies = new BP_Repo_Companies($wpdb, 'wp_portal_', 1);
		$result_array = $BP_Repo_Companies->map_result('\BP_Company', $data_array);

		$this->assertEquals(3, count($result_array));
		$this->assertEquals(13, $result_array[13]->id);
		$this->assertEquals("This is test for 14", $result_array[14]->company_name);
		$this->assertEquals(10, $result_array[14]->year_of_incorporate);
		$this->assertEquals('Majid', $result_array[14]->ceo_md);		
	}

	public function get_sample_data()
	{
		return array(
			array(
				'id' => 12,
				'user_id' => 343,
				'company_name' => "This is test for 12",
				'turnover_min' => 100001,
				'turnover_max' => 100000000,
			),
			array(
				'id' => 13,
				'user_id' => 500,
				'company_name' => "This is test for 13",
				'turnover_min' => 200001,
				'turnover_max' => 200000000,
			),
			array(
				'id' => 14,
				'user_id' => 600,
				'company_name' => "This is test for 14",
				'turnover_min' => 500001,
				'turnover_max' => 500000000,
				'year_of_incorporate' => 10,
				'ceo_md' => 'Majid',
			),
		);
	}
}
