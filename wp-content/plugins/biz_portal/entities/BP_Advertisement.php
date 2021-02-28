<?php
/**
 * classs BP_Advertisement
 *
 * @package entites
 * @author SWISS BUREAU
 */
class BP_Advertisement
{
	/**
	 * @var int $id
	 */
	public $id;

	/**
	 * @var string $ad_type
	 */
	public $ads_type;	

	/**
	 * @var int $image_id
	 */
	public $image_id;

	/**
	 * @var string $link_url
	 */
	public $link_url;

	/**
	 * @var int $company_id;
	 */
	public $company_id;

	const ADS_TYPE_NEWSROOM	= 'ADS_TYPE_NEWSROOM';
	const ADS_TYPE_RESOURCE	= 'ADS_TYPE_RESOURCE';
	const ADS_TYPE_LOGIN 	= 'ADS_TYPE_LOGIN';
	const ADS_TYPE_SIDEBAR 	= 'ADS_TYPE_SIDEBAR';
	//const ADS_TYPE_


	//================================

	/**
	 * @var BP_File $image;
	 */
	public $image;

	/**
	 * @var BP_AdsClick $ads_click
	 */
	public $ads_click;


	/**
	 * @var string $table_name
	 */
	public static $table_name = 'advertisements';


	/**
	 * Class construct
	 * 
	 * @param int $id
	 */
	public function __construct($id = 0, $ad_type = self::ADS_TYPE_NEWSROOM)
	{
		$this->id = $id;
		$this->ad_type = $ad_type;
	}

	/**
     * Convert this class to array
     * 
     * @return array
     */
    public function to_array()
    {
    	return array(
    		'id' => $this->id,
    		'ads_type' => $this->ads_type,
    		'image_id' => $this->image_id,
    		'link_url' => $this->link_url,
    		'company_id' => $this->company_id,
    	);
    }
}