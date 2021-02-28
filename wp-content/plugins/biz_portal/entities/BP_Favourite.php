<?php
/**
 * classs BP_Favourite
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_Favourite
{
	public $company_id;
	public $target_company_id;
	public $created;
	
	//
	// =============
	
	/**
	 * @var BP_Company $company
	 */
	public $company;
	
	/**
	 * @var BP_Company $target_company
	 */
	public $target_company;
	
	
	/**
	 * @var string $table_name
	 */
	public static $table_name = 'favourites';
	
	/**
	 * Class construct
	 *
	 * @param int $id
	 */
	public function __construct($c_id = 0, $t_com_id = 0)
	{
		$this->company_id = $id;
		$this->target_company_id = $t_com_id;
		$this->created = date("Y-m-d H:i:s");
	}

	/**
	 * Return class as array
	 */
	public function to_array()
	{
		return array(
			'company_id' => $this->company_id,
			'target_company_id' => $this->target_company_id,
			'created' => $this->created,
		);
	}
}