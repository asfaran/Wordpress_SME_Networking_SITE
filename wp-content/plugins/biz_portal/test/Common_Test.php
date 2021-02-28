<?php

class Common_Test extends PHPUnit_Framework_TestCase
{
	public function test_time()
	{
		$now = time();
		$now_int = intval($now);
		$this->assertEquals($now, $now_int);	
	}
}