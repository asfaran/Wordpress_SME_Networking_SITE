<?php

require_once(__DIR__ . '/../entities/BP_File.php');
require_once(__DIR__ . '/../entities/BP_Node.php');
require_once(__DIR__ . '/../includes/BP_Hydrator.php');

class BP_Hydrator_Test extends PHPUnit_Framework_TestCase
{
	public function testHydrate()
	{

		$data_array = array(
			'id' => 12,
			'title' => "This is test",
			'attachment_id' => 55,
			'attachment_path' => '/tmp/myfile.jpg',
		);

		$node = new BP_Node();

		BP_Hydrator::hydrate($node, $data_array);
		$node->attachment[0] = new BP_File();
		BP_Hydrator::hydrate($node->attachment[0], $data_array, 'attachment_');

		$this->assertEquals(12, $node->id);
		$this->assertEquals(55, $node->attachment[0]->id);
		$this->assertEquals('This is test', $node->title);
		$this->assertEquals('/tmp/myfile.jpg', $node->attachment[0]->path);
	}
}