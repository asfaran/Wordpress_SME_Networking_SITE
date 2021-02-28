<?php
/**
 * classs BP_AdsClick
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_AdsClick
{
	/**
	 * @var int $ads_id
	 */
	public $ads_id;

	/**
	 * @var int $clicks_count;
	 */
	public $clicks_count;

	/**
	 * @var int $views_count
	 */
	public $views_count;

	/**
	 * @var string $table_name
	 */
	public static $table_name = 'ads_clicks';

	/**
	 * Class construct
	 * 
	 * @param int $id
	 */
	public function __construct($id = 0)
	{
		$this->ads_id = $id;		
	}

	public function to_array()
	{
		return array(
			'ads_id' => $this->ads_id,
			'clicks_count' => $this->clicks_count,
			'views_count' => $this->views_count,
		);
	}
}