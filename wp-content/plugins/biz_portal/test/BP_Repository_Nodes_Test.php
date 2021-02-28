<?php

require_once(__DIR__ . '/../test/wpdb.php');
require_once(__DIR__ . '/../entities/BP_File.php');
require_once(__DIR__ . '/../entities/BP_Node.php');
require_once(__DIR__ . '/../includes/BP_Hydrator.php');
require_once(__DIR__ . '/../includes/BP_BaseRepository.php');
require_once(__DIR__ . '/../includes/BP_Repo_Nodes.php');

class BP_Respository_Nodes_Test extends PHPUnit_Framework_TestCase
{
	public function testMapToObject()
	{

		$data_array = $this->get_sample_data();

		$wpdb = $this->getMock('wpdb');
		$BP_Repo_Nodes = new BP_Repo_Nodes($wpdb, 'mock');
		$result_array = $BP_Repo_Nodes->map_result_to_object_array($data_array);

		$this->assertEquals(3, count($result_array));
		$this->assertEquals(55, $result_array[55]->id);
		$this->assertEquals('This is test for 55', $result_array[55]->title);
		$this->assertEquals('This is test for 12', $result_array[12]->title);
		$this->assertEquals(35, $result_array[12]->attachments[35]->id);
		$this->assertEquals(15, $result_array[55]->attachments[15]->id);
		$this->assertEquals('/tmp/myfile_18.jpg', $result_array[55]->attachments[18]->path);
		$this->assertEquals(4543534, $result_array[12]->attachments[37]->size);
	}

	public function get_sample_data()
	{
		return array(
			array(
				'id' => 12,
				'title' => "This is test for 12",
				'attachment_id' => 35,
				'attachment_path' => '/tmp/myfile.jpg',
			),
			array(
				'id' => 12,
				'title' => "This is test for 12",
				'attachment_id' => 36,
				'attachment_path' => '/tmp/myfile_36.jpg',
			),
			array(
				'id' => 12,
				'title' => "This is test for 12",
				'attachment_id' => 37,
				'attachment_path' => '/tmp/myfile_37.jpg',
				'attachment_size' => 4543534,
			),
			array(
				'id' => 55,
				'title' => "This is test for 55",
				'attachment_id' => 15,
				'attachment_path' => '/tmp/myfile_12.jpg',
			),
			array(
				'id' => 55,
				'title' => "This is test for 55",
				'attachment_id' => 18,
				'attachment_path' => '/tmp/myfile_18.jpg',
			),
			array(
				'id' => 56,
				'title' => "This is test for 56",
				'attachment_id' => 19,
				'attachment_path' => '/tmp/myfile_19.jpg',
			),
		);
	}
}
