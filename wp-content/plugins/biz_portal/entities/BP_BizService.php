<?php
/**
 * Class BP_BizService
 * 
 * @package entites
 * @author muneer
 *
 */
class BP_BizService
{
	/** @var int Identifier */
	public $id;
	/** @var string Service name */
	public $service_name;
	/** @var int Was it created by the applicant? */
	public $is_user_value;

	/** @var string Table name */
	public static $table_name = 'biz_services';

	/**
	 * Class construct
	 * 
	 * @param int $id
	 */
	public function __construct($id = 0) {
		$this->id = $id;
		$this->is_user_value = 0;
	}
	
	/**
	 * Convert the class properties to array
	 * 
	 * @return array
	 */
	public function to_array()
	{
		return array(
			'id' => $this->id,
			'service_name' => $this->service_name,
			'is_user_value' => $this->is_user_value,
		);
	}
}