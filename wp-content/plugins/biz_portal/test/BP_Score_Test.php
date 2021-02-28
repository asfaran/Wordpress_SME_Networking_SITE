<?php
require_once(__DIR__ . '/../entities/BP_Score.php');

class BP_Score_Test extends PHPUnit_Framework_TestCase
{
	public function test_create_object()
	{
		$score = new BP_Score();
		$this->assertEquals(0, $score->scores);
		$this->assertEquals(0, $score->company_id);
		
		$score->add_score(20);
		$this->assertEquals(20, $score->scores);
	}
}